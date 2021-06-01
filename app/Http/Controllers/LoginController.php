<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use Atymic\Twitter\Facades\Twitter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    //
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * LoginController constructor.
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function login()
    {
        //return Socialite::driver('twitter')->redirect();
        $token = Twitter::getRequestToken(route('twitter.callback'));

        if (isset($token['oauth_token_secret'])) {
            $url = Twitter::getAuthenticateUrl($token['oauth_token']);

            Session::put('oauth_state', 'start');
            Session::put('oauth_request_token', $token['oauth_token']);
            Session::put('oauth_request_token_secret', $token['oauth_token_secret']);

            return redirect('twitter/timeline');
        }

        return "Error";

    }

    public function oauthBack()
    {
        if (Session::has('oauth_request_token')) {
            $twitter = Twitter::usingCredentials(session('oauth_request_token'), session('oauth_request_token_secret'));
            $token = $twitter->getAccessToken(request('oauth_verifier'));

            if (!isset($token['oauth_token_secret'])) {
                return Redirect::route('twitter.error')->with('flash_error', 'We could not log you in on Twitter.');
            }

            // use new tokens
            $twitter = Twitter::usingCredentials($token['oauth_token'], $token['oauth_token_secret']);
            $credentials = $twitter->getCredentials();

            if (is_object($credentials) && !isset($credentials->error)) {
                Session::put('access_token', $token);

                $userWhere = User::where('oauth_type', "twitter")
                    ->where("oauth_id", $credentials->id)
                    ->first();

                if ($userWhere) {
                    Auth::login($userWhere);
                    return redirect('twitter/timeline');
                } else {

                    $newUser = User::create([
                        'oauth_type' => 'twitter',
                        'oauth_id' => $credentials->id,
                        'nickname' => $credentials->screen_name,
                        'name' => $credentials->name,
                        'avatar' => $credentials->profile_image_url,
                    ]);

                    Auth::login($newUser);

                    return redirect('twitter/timeline');
                }
            }
        }
    }
}
