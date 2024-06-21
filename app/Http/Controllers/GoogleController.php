<?php

namespace App\Http\Controllers;
use Google_Client;
use Illuminate\Http\Request;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));

        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->addScope('email');
        $client->addScope('profile');
   
        $auth_url = $client->createAuthUrl();
dd($auth_url);
        return redirect()->away($auth_url);
    }

        public function handleGoogleCallback(Request $request)
    {
        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->addScope('email');
        $client->addScope('profile');

        $token = $client->fetchAccessTokenWithAuthCode($request->input('code'));

        if (isset($token['error'])) {
            return response()->json(['error' => 'Something went wrong. Please try again.'], 500);
        }

        $client->setAccessToken($token['access_token']);

        // Get user info
        $oauth2 = new Google_Service_Oauth2($client);
        $googleUser = $oauth2->userinfo->get();
    }

}
