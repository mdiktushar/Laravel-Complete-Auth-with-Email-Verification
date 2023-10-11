<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home() {
        return view('home');
    }

    public function viewLogin() {
        return view('auth.login');
    }

    public function viewRegister() {
        return view('auth.register');
    }

    public function viewDashboard() {
        return view('pages.dashboard');
    }

}
