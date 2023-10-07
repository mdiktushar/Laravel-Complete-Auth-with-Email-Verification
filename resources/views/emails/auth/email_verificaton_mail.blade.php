<x-mail::message>
    # Introduction

    Please Verify your email address for the Auth system application.

    <x-mail::button :url="{{ route('verify_email', $user->verification_code) }}">

        Click Hear
    </x-mail::button>

    Thanks,<br>

</x-mail::message>
