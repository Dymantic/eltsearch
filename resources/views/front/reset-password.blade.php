<x-public-page :dontIndex="true">
    <div class="my-20 px-6 max-w-3xl mx-auto text-center">
        <h1 class="type-h2 text-navy mb-12">{{ trans('login.reset.heading') }}</h1>
        <p class="max-w-xl mx-auto type-b1">{{ trans('login.reset.intro') }}</p>
    </div>

    <form action="/password/reset" method="post" class="max-w-md mx-auto">
        {!! csrf_field() !!}
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="my-6">
            <label class="form-label" for="email">{{ trans('login.reset.email_label') }}:</label>
            @error('email')
            <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
            <input type="email" name="email" id="email" value="{{ $email }}" class="form-text-input">
        </div>
        <div class="my-6">
            <label class="form-label" for="password">{{ trans('login.reset.choose_password') }}:</label>
            @error('password')
            <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
            <input type="password" id="password" name="password" class="form-text-input">
        </div>
        <div class="my-6">
            <label class="form-label" for="password_confirmation">{{ trans('login.reset.confirm_password') }}:</label>

            <input type="password" id="password_confirmation" name="password_confirmation" class="form-text-input">
        </div>
        <div class="my-12 text-center">
            <button type="submit" class="btn-main type-a1">{{ trans('login.reset.submit') }}</button>
        </div>
    </form>
</x-public-page>
