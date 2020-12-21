@component('mail::message')

## Hey there,

{{ $body }}

@foreach($extra_fields as $label => $text)
**{{ $label }}:** {{ $text }}

@endforeach

@component('mail::button', ['url' => $url])
{{ $action }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
