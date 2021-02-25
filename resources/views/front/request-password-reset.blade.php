<x-public-page>
    <div class="my-20 px-6 max-w-3xl mx-auto text-center">
        <h1 class="type-h2 text-navy mb-12">{{ trans('login.request_password.heading') }}</h1>
        <p class="max-w-xl mx-auto type-b1">{{ trans('login.request_password.intro') }}</p>
    </div>

    @if(session('status'))
        <div class="max-w-md mx-auto border border-navy rounded-lg p-6 bg-baby-blue my-12">
            <p class="type-b1 text-navy">{{ trans('login.request_password.link_sent') }}</p>
        </div>
    @endif

    <form action="/password/request" method="post" class="max-w-md mx-auto">
        {!! csrf_field() !!}
        <div>
            <label class="form-label" for="email">{{ trans('login.email_label') }}:</label>
            @error('email')
            <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-text-input">
        </div>
        <div class="my-12 text-center">
            <button type="submit" class="btn-main type-a1">{{ trans('login.request_password.submit') }}</button>
        </div>
    </form>
</x-public-page>
