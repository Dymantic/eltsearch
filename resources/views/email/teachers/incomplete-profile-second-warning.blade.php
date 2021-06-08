@component('mail::message')

Hi {{ $name }}

We see that your profile on ELTSearch is still not complete. If you'd like to qualify to get matched with available teaching opportunities, please take a moment to complete your profile.

This will be the last request we will send you. We will delete incomplete profiles after two weeks. Complete your profile and become part of the great community at ELTSearch now.

@component('mail::button', ['url' => $url])
    {{ $action }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
