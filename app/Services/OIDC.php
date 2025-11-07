<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

class OIDC
{
    private array $discovery;

    public function __construct(
        private array $config,
        private UrlGenerator $url,
        private ResponseFactory $response,
        private HttpFactory $http,
        private SessionManager $session,
    ) {
        $this->discover();
    }

    private function http(): PendingRequest
    {
        return $this->http->withOptions([
            'verify' => $this->config['verify_certs'],
        ]);
    }

    private function discover(): void
    {
        $this->discovery = $this->http()->get($this->config['discovery'])
            ->throw()
            ->json();
    }

    private function decode(string $jwt): array
    {
        [$header, $payload] = explode('.', $jwt);

        return json_decode(base64_decode($payload), true);
    }

    public function redirectUrl(string $state): string
    {
        $query = [
            'response_type' => 'code',
            'client_id' => $this->config['client_id'],
            'scope' => str($this->config['scopes'])->replace(',', ' ')->toString(),
            'redirect_uri' => $this->url->route('oidc.callback'),
            'state' => $state,
        ];

        return $this->url->query($this->discovery['authorization_endpoint'], $query);
    }

    public function redirect(): RedirectResponse
    {
        $this->session->invalidate();

        $state = Uuid::uuid7();

        $this->session->put('oidc_session_state', $state);

        $target = $this->redirectUrl($state);

        return $this->response->redirectTo($target);
    }

    public function callback(Request $request): void
    {
        $stateFromSession = $this->session->get('oidc_session_state');
        $stateFromUrl = $request->query->getString('state');

        if ($stateFromSession != $stateFromUrl) {
            $this->session->invalidate();
            abort(403, 'invalid state');
        }

        $payload = [
            'grant_type' => 'authorization_code',
            'code' => $request->query->getString('code'),
            'redirect_uri' => route('oidc.callback'),
            'client_id' => $this->config['client_id'],
            'client_secret' => $this->config['client_secret'],
        ];

        $response = $this->http()
            ->asForm()
            ->post($this->discovery['token_endpoint'], $payload)
            ->throw()
            ->json();

        $accessToken = $this->decode($response['access_token']);
        $refreshToken = $this->decode($response['refresh_token']);
        $idToken = $this->decode($response['id_token']);

        // TODO: Access Control
        /** @var User */
        $user = User::whereEmail($accessToken['email'])->firstOrNew();

        $user->email = $accessToken['email'];
        $user->name = $accessToken['name'];
        $user->provider = 'openid-connect';

        if (! $user->hasVerifiedEmail()) {
            $user->email_verified_at = now();
        }

        $user->save();

        Auth::login($user);
    }
}
