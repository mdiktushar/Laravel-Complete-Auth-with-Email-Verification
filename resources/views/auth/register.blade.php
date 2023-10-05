@extends('Layout.mainLayout')
@section('body')
    <h1 class="text-center">Register</h1>
    <form action="" class="flex flex-col items-center">
        @csrf
        <div class="form-control w-full max-w-xs">
            <label class="label">
                <span class="label-text">First Name</span>
            </label>
            <input type="text" placeholder="Type here" class="input input-bordered w-full max-w-xs" />
        </div>
        <div class="form-control w-full max-w-xs">
            <label class="label">
                <span class="label-text">Last Name</span>
            </label>
            <input type="text" placeholder="Type here" class="input input-bordered w-full max-w-xs" />
        </div>
        <div class="form-control w-full max-w-xs">
            <label class="label">
                <span class="label-text">Email</span>
            </label>
            <input type="text" placeholder="Type here" class="input input-bordered w-full max-w-xs" />
        </div>
        <div class="form-control w-full max-w-xs">
            <label class="label">
                <span class="label-text">Password</span>
            </label>
            <input type="text" placeholder="Type here" class="input input-bordered w-full max-w-xs" />
        </div>
        <div class="form-control w-full max-w-xs">
            <label class="label">
                <span class="label-text">Confirm Password</span>
            </label>
            <input type="text" placeholder="Type here" class="input input-bordered w-full max-w-xs" />
        </div>
        <div class="g-recaptcha mt-5" data-sitekey="{{ env('reCAPTCHA_site_key') }}" data-callback="onCaptchaSuccess"
            data-expired-callback="onCaptchaExpired">
        </div>
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
