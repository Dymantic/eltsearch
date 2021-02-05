@component('mail::message')

The following is a message from {{ $sender_name }} ({{ $sender_email }}), sent via the ELT Search website.

{{ $message_body }}

@component('mail::button', ['url' => $url])
    {{ $action }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
