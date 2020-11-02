@component('mail::message')

{{ $body }}

@component('mail::button', ['url' => $url])
{{ $action }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
