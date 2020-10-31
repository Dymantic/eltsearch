@component('mail::message')

{{ $body }}

@if($image)
<img src="{{ $image }}" style="display: block; margin: 20px auto; width: 150px; border-radius: 100%" alt="Teachers avatar">
@endif

@component('mail::button', ['url' => $url])
{{ $action }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
