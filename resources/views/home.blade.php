@extends('Layout.mainLayout')
@section('body')
    <div class="text-center">
        <h2 class="mb-5">Please login or register</h2>
        <div class="flex gap-2 items-center justify-center">
            <a class="btn btn-success" href={{ route('loginPage') }}>Login</a>
            <a class="btn btn-info" href={{ route('registerPage') }}>Register</a>
        </div>
    </div>
@endsection