<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //

    public function register(RegisterRequest $request)
    {
        $grecaptcha = $request->recapture;

        $client = new Client();

        $response = $client->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'form_params' => [
                    'secret' => env('reCAPTCHA_secret_key'),
                    'response' => $grecaptcha
                ]
            ]
        );

        $body = json_decode((string)$response->getBody());

        if ($body->success == true) {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'email_verified_code' => Str::random(40)
            ]);

            return redirect()->back()->with('success', 'Registration successfull.Please check your email address for email verification link.');
        } else {
            return redirect()->back()->with('error', 'Invalid Recaptcha');
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'recapture' => 'required'
        ]);
    }
}
