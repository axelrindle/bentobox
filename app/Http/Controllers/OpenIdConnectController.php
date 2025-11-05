<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Ramsey\Uuid\Uuid;

class OpenIdConnectController extends Controller
{
    public function login(Request $request)
    {
        $config = config('oidc');

        $discovered = Http::withOptions([
            'verify' => $config['verify_certs'],
        ])
            ->get($config['discovery'])
            ->throw()
            ->json();

        $query = [
            'response_type' => 'code',
            'client_id' => $config['client_id'],
            'scope' => str($config['scopes'])->replace(',', ' ')->toString(),
            'redirect_uri' => route('oidc.callback'),
            'state' => Uuid::uuid7(),
        ];

        $target = url()->query($discovered['authorization_endpoint'], $query);

        return response()->redirectTo($target);
    }

    public function callback(Request $request)
    {
        // TODO: verify session state

        $config = config('oidc');

        $discovered = Http::withOptions([
            'verify' => $config['verify_certs'],
        ])
            ->get($config['discovery'])
            ->throw()
            ->json();

        $payload = [
            'grant_type' => 'authorization_code',
            'code' => $request->query->getString('code'),
            'redirect_uri' => route('oidc.callback'),
            'client_id' => $config['client_id'],
            'client_secret' => $config['client_secret'],
        ];

        $response = Http::withOptions([
            'verify' => $config['verify_certs'],
        ])
            ->asForm()
            ->post($discovered['token_endpoint'], $payload)
            ->throw()
            ->json();

        $accessToken = $this->decode($response['access_token']);
        $refreshToken = $this->decode($response['refresh_token']);
        $idToken = $this->decode($response['id_token']);

        // TODO: Access Control
        $user = User::whereEmail($accessToken['email'])->firstOrNew();

        $user->email = $accessToken['email'];
        $user->name = $accessToken['name'];
        $user->provider = 'openid-connect';

        $user->save();

        Auth::login($user);

        return response()->redirectToRoute('dashboard');
    }

    private function decode(string $jwt): array
    {
        [$header, $payload] = explode('.', $jwt);

        return json_decode(base64_decode($payload), true);
    }
}
