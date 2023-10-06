@extends('Layout.mainLayout')
@section('body')
    <h1 class="text-center">Register</h1>
    <form action={{ route('register') }} method="POST" class="flex flex-col items-center">
        @csrf
        <div class="flex gap-3">
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">First Name</span>
                </label>
                <input type="text" name="firstName" value={{ old('firstName') }} placeholder="Type here"
                    class="input input-bordered w-full max-w-xs @error('firstName') border-red-600 placeholder-red-500 @enderror " />
                @error('firstName')
                    <p class="text-red-600 text-xs">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Last Name</span>
                </label>
                <input type="text" name="lastName" value={{ old('lastName') }} placeholder="Type here"
                    class="input input-bordered w-full max-w-xs @error('lastName') border-red-600 placeholder-red-500 @enderror " />
                @error('lastName')
                    <p class="text-red-600 text-xs">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="form-control w-full max-w-xs">
            <label class="label">
                <span class="label-text">Email</span>
            </label>
            <input type="text" name="email" value={{ old('email') }} placeholder="Type here"
                class="input input-bordered w-full max-w-xs @error('email') border-red-600 placeholder-red-500 @enderror " />
            @error('email')
                <p class="text-red-600 text-xs">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex gap-3">
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Password</span>
                </label>
                <input type="password" name="password" value={{ old('password') }} placeholder="Type here"
                    class="input input-bordered w-full max-w-xs @error('password') border-red-600 placeholder-red-500 @enderror " />
                @error('password')
                    <p class="text-red-600 text-xs">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Confirm Password</span>
                </label>
                <input type="password" name="password_confirmation" value={{ old('password_confirmation') }}
                    placeholder="Type here"
                    class="input input-bordered w-full max-w-xs @error('password') border-red-600 placeholder-red-500 @enderror " />
                @error('password')
                    <p class="text-red-600 text-xs">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="g-recaptcha mt-5" data-sitekey="{{ env('reCAPTCHA_site_key') }}" data-callback="onCaptchaSuccess"
            data-expired-callback="onCaptchaExpired">
        </div>
        @error('recapture')
            <p class="text-red-600 text-xs">Prove your are not a robort</p>
        @enderror
        <input type="hidden" name="recapture" id="recaptudre">
        <button type="submit" class="btn btn-success mt-5">Success</button>
    </form>

    <script>
        function onCaptchaSuccess(response) {
            var inputElement = document.getElementById("recaptudre");
            inputElement.value = response;
        }

        function onCaptchaExpired() {
            var inputElement = document.getElementById("recaptudre");
            inputElement.value = '';
        }
    </script>
@endsection
