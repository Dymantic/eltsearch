@component('mail::message')

Hi {{ $name }}

I've told you once, and now I'm telling you twice. If you don't complete your profile, I'm coming for you.

You profile is considered incomplete because it is missing one of the following: a profile picture, your teaching experience, your nationality, your age, native language or years of teaching experience. Please complete your profile to make ELTSearch a better opportunity for all.

@component('mail::button', ['url' => $url])
    {{ $action }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
