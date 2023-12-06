@component('mail::message')

Welcome to laravel
      
Name: {{ $mailData['name'] }}<br/>
Email: {{ $mailData['email'] }}
      
Thanks,<br/>
{{ config('app.name') }}

@endcomponent

