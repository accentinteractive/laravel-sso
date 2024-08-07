<?php

namespace Accentinteractive\LaravelSso\Services\Sso;

use App\Models\User;
use App\Services\Logger;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use TheNetworg\OAuth2\Client\Provider\Azure;

class AzureADSso
{

    const OAUTH2STATE = 'oauth2state';

    /**
     * Azure Application (client) ID
     *
     * @var string
     */
    protected $clientId;

    /**
     * Azure Application (client) secret.
     *
     * @var string
     */
    protected $clientSecret;

    /**
     * Azure Application (client) redirect URL.
     *
     * @var string
     */
    protected $redirectUrl;

    protected Azure $provider;

    public function __construct()
    {
        $appData = [
            'clientId' => config('sso.client_id'),
            'clientSecret' => config('sso.client_secret'),
            'redirectUri' => config('sso.client_redirect_url'),
        ];

        $this->provider = new Azure($appData);
    }

    public function requestIsAzureRedirect()
    {
        return request()->has('code') === true;
    }

    public function isValidAzureLoginRequest()
    {
        return request()->get('state') === session(self::OAUTH2STATE);
    }

    public function getAzureLoginUrl()
    {
        $authUrl = $this->provider->getAuthorizationUrl();
        session([self::OAUTH2STATE => $this->provider->getState()]);

        return $authUrl;
    }

    public function loginUsingStateToken()
    {
        $authorizationData = [
            'code' => request()->get('code'),
            'resource' => 'https://graph.windows.net',
        ];
        $token = $this->provider->getAccessToken('authorization_code', $authorizationData);

        try {
            // Get the user's details from Azure AD
            $me = $this->provider->get('me', $token);

            // Create Auth session for this user
            $email = Arr::get($me, 'userPrincipalName');
            if (empty($email)) {
                throw new AzureSsoException('Azure data does not contain email');
            }

            $user = User::where('email', $email)->first();
            if (empty($user)) {
                throw new AzureSsoException('Could not find user ' . Arr::get($me, 'displayName'));
            }

            DB::table('sessions')->where('user_id', $user->id)->delete();
            Auth::login($user);

            // Delete all sessions for this user
            // $this->session->delete_by_user($this->session->userdata('c_user_id'));

            // Store this user's ID in session
            // $this->session->set_user_id($this->session->userdata('c_user_id'));
        } catch (Exception $e) {
            throw new AzureSsoException('An error occured during authentication');
        }
    }

    public function abort($message = null)
    {
        session()->forget(self::OAUTH2STATE);

        abort(403, $message);
    }
}
