<x-mail::message>
    # Introduction

    Please Verify your email address for the Auth system application.

    <x-mail::button  :url="http://127.0.0.1:8000/auth/verify-email/{{$user->email_verified_code}}">
        Click Hear
    </x-mail::button>

    Thanks,<br>

</x-mail::message>
