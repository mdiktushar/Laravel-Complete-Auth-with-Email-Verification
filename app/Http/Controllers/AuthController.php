<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Mail\EmailVerificationMail;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
                'first_name' => $request->firstName,
                'last_name' => $request->lastName,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'email_verified_code' => Str::random(40),
            ]);
            session()->flash('success', 'Registration successfull. Please check your email address for email verification link.');
            Mail::to($request->email)->send(new EmailVerificationMail($user));
            
            return redirect()->route('registerPage');
        } else {
            session()->flash('error', 'Invalid Recaptcha');
            return redirect()->route('registerPage');
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

    public function verify_email ($verification_code) {
        $user = User::where('email_verified_code', $verification_code)->first();

        if(!$user) {
            session()->flash('error', 'Not Verified');
            return redirect()->route('registerPage');
        } else {
            if($user->email_verified_at) {
                session()->flash('error', 'Already Verified');
                return redirect()->route('registerPage');
            } else {
                $user->update([
                    'email_verified_at'=> Carbon::now()
                ]);
                session()->flash('success', 'Verified');
                return redirect()->route('registerPage');
            }

        }
    }
}
