<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Mail\EmailVerificationMail;
use App\Mail\ForgetPassword;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                    'email_verified_at'=> Carbon::now(),
                    'is_active' => true
                ]);
                session()->flash('success', 'Verified');
                return redirect()->route('registerPage');
            }

        }
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'recapture' => 'required'
        ]);

        $grecaptcha = $request->required;

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
            $user = User::where('email', $request->email)->first();

            if(!$user) {
                session()->flash('error', 'Email not found!');
                return redirect()->route('loginPage');
            } else {
                if (!$user->email_verified_at) {
                    session()->flash('error', 'User is not verified');
                    return redirect()->back();
                } else {
                    if(auth()->attempt($request->only('email', 'password'))) {
                        
                        return redirect()->route('dashboardPage');
                    } else {
                        session()->flash('error', 'Password is not correct');
                        return redirect()->back();
                    }
                }
            }
        } else {
            session()->flash('error', 'Invalid Recaptcha');
            return redirect()->back();
        }
    }

    public function forgerPassword () {
        return view('auth.forgetPassword');

    }

    public function sendForgetPasswordEmail (Request $request) {

        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            session()->flash('error', 'No account with this email');
            return redirect()->back();
        }

        $OTP =  rand(1111, 9999);

        $user->update([
            'OTP' => $OTP,
        ]);
        session()->flash('success', 'Please Check Your Email');
        Mail::to($request->email)->send(new ForgetPassword($OTP, $user));
        return view('auth.resetPassword');
    }


    public function logout () {
        Auth::logout();
        return redirect('/');
    }
}
