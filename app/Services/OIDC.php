<?php

namespace App\Services;

use App\Exceptions\BootException;
use App\Models\User;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Factory as ValidatorFactory;
use Illuminate\Validation\ValidationException;
use Ramsey\Uuid\Uuid;

class OIDC
{
    private bool $isEnabled = true;

    /**
     * Discovered OpenID Endpoint Configuration
     *
     * @var array<string,mixed>
     */
    private array $discovery;

    /**
     * @param  array<string,mixed>  $config
     */
    public function __construct(
        private array $config,
        private HttpFactory $http,
        private ResponseFactory $response,
        private SessionManager $session,
        private UrlGenerator $url,
        private ValidatorFactory $validation,
    ) {
        if ($config['enabled'] !== true) {
            $this->isEnabled = false;

            return;
        }

        $validator = $validation->make($config, [
            'discovery' => 'required|url',
            'verify_certs' => 'required|boolean:strict',
            'client_id' => 'required|string',
            'client_secret' => 'required|string',
            'scopes' => 'required|string',
        ]);
        if ($validator->fails()) {
            throw new BootException('oidc discovery response validation failed', previous: new ValidationException($validator));
        }

        $this->discover();
    }

    private function ensureEnabled()
    {
        if (! $this->isEnabled) {
            throw new BootException('oidc is not enabled');
        }
    }

    private function http(): PendingRequest
    {
        $this->ensureEnabled();

        return $this->http->withOptions([
            'verify' => $this->config['verify_certs'],
        ]);
    }

    private function discover(): void
    {
        $this->ensureEnabled();

        $discovery = $this->http()->get($this->config['discovery'])
            ->throw()
            ->json();

        $validator = $this->validation->make($discovery, [
            'issuer' => 'required|string',
            'authorization_endpoint' => 'required|url',
            'token_endpoint' => 'required|url',
            'introspection_endpoint' => 'required|url',
            'userinfo_endpoint' => 'required|url',
            'end_session_endpoint' => 'required|url',
        ]);
        if ($validator->fails()) {
            throw new BootException('oidc discovery response validation failed', previous: new ValidationException($validator));
        }

        $this->discovery = $discovery;
    }

    private function decode(string $jwt): array
    {
        [$header, $payload] = explode('.', $jwt);

        return json_decode(base64_decode($payload), true);
    }

    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }

    public function redirectUrl(string $state): string
    {
        $this->ensureEnabled();

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
        $this->ensureEnabled();

        $this->session->invalidate();

        $state = Uuid::uuid7();

        $this->session->put('oidc_session_state', $state);

        $target = $this->redirectUrl($state);

        return $this->response->redirectTo($target);
    }

    public function callback(Request $request): void
    {
        $this->ensureEnabled();

        $stateFromSession = $this->session->get('oidc_session_state');
        $stateFromUrl = $request->query->getString('state');

        if ($stateFromSession != $stateFromUrl) {
            $this->session->invalidate();
            abort(406, 'invalid state');
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

        if ($accessToken['iss'] != $this->discovery['issuer']) {
            $this->session->invalidate();
            abort(406, sprintf('invalid issuer: expected issuer "%s" did not match incoming issuer "%s"',
                $this->discovery['issuer'],
                $accessToken['iss']));
        }

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
