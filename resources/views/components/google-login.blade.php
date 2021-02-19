<div class="flex max-w-xs mx-auto rounded-lg overflow-hidden">
    <div class="flex justify-center items-center bg-medium-gray px-6 py-3 w-16">
        <a id="google-redirect-url" href="{{ $redirect }}" class="text-navy hover:text-sky-blue hashed-login-link">
            @include('svg.icons.google', ['classes' => 'h-6'])
        </a>
    </div>
    <div class="flex-1 w-48 text-navy hover:text-sky-blue type-b2 text-center flex justify-center items-center ml-1 bg-medium-gray">
        <p><a class="hashed-login-link" href="{{$redirect}}">{{ $text }}</a></p>
    </div>

</div>
