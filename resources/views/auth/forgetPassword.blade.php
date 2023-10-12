@extends('Layout.mainLayout')
@section('body')
    <h1>Forget Password</h1>
    @if (session('success'))
        <div class="alert alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @elseif (session('error'))
        <div class="alert alert-error">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <form action={{ route('login') }} method="POST" class="flex flex-col items-center">
        @csrf
        <div class="form-control w-full max-w-xs">
            <label class="label">
                <span class="label-text">Email</span>
            </label>
            <input type="text" name="email" placeholder="Type here"
                class="input input-bordered w-full max-w-xs @error('email') border-red-600 placeholder-red-500 @enderror " />
            @error('email')
                <p class="text-red-600 text-xs">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="btn btn-success mt-5">Send OTP</button>
        <br>
        <a href={{ route('loginPage') }} class="btn text-green-500">Got TO Login</a>
    </form>
@endsection