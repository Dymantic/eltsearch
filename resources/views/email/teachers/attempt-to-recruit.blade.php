@component('mail::message')

The following is a message from {{ $school }}, who have viewed your profile and would like to make contact:

{{ $body }}

@foreach($extra_fields as $label => $text)
**{{ $label }}:** {{ $text }}

@endforeach

@if($image)
<img src="{{ $image }}" style="display: block; margin: 20px auto; width: 150px;" alt="school logo">
@endif

@component('mail::button', ['url' => $url])
{{ $action }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
