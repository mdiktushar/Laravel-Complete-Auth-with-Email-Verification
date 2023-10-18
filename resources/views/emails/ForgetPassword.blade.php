<x-mail::message>
# Introduction

Hello User {{$name}}. <br>
This is your OTP: {{$OTP}}.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
