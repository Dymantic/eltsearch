<div class="flex max-w-xs mx-auto rounded-lg overflow-hidden">
    <div class="flex justify-center items-center bg-medium-gray px-6 py-3">
        <a id="fb-redirect-url" href="{{ $redirect }}" class="text-navy hover:text-sky-blue">
            @include('svg.icons.facebook', ['classes' => 'h-6'])
        </a>
    </div>
    <div class="flex-1 text-navy hover:text-sky-blue type-b2 text-center flex justify-center items-center ml-1 bg-medium-gray">
        <p><a id="fb-redirect-url-2" href="{{$redirect}}">{{ $text }}</a></p>
    </div>
    <script>
        const hash = window.location.hash.slice(2);
        const a = document.getElementById('fb-redirect-url');
        a.href = a.href + `?hash=${hash}`;

        const b = document.getElementById('fb-redirect-url-2');
        b.href = b.href + `?hash=${hash}`;
    </script>
</div>
