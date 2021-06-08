@component('mail::message')

Hi {{ $name }}

We've noticed your profile on ELTSearch is still not ready. Unfortunately, this does not qualify you to match with available teaching opportunities.

Please take a quick moment to complete your profile so that you can become part of the great community at ELTSearch.

@component('mail::button', ['url' => $url])
    {{ $action }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
