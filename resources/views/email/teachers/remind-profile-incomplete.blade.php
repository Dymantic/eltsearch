@component('mail::message')

Hi {{ $name }}

We have noticed that your profile on ELTSearch has not been completed yet. Completing your profile gives you better chances of finding the right job for you, even if you are not actively looking right now.

You profile is considered incomplete because it is missing one of the following: a profile picture, your teaching experience, your nationality, your age, native language or years of teaching experience. Please complete your profile to make ELTSearch a better opportunity for all.

@component('mail::button', ['url' => $url])
    {{ $action }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
