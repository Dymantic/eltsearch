<x-public-page :dontIndex="true">
    <div class="my-20 px-6 text-center">
        <h1 class="type-h2 text-navy mb-8 max-w-3xl mx-auto">{{ trans('login.heading') }}</h1>

    </div>

    <div class="mb-12 px-6">
        <div class="flex flex-col justify-center items-center">
            <div class="my-4">
                <x-facebook-login text="{{ trans('login.facebook') }}" redirect="/login/facebook"></x-facebook-login>
            </div>
            <div class="my-4">
                <x-google-login redirect="/login/google" text="{{ trans('login.google') }}"></x-google-login>
            </div>
        </div>

        @error('facebook_login')
        <p class="text-red-500 text-xs text-center mt-2">{{ $message }}</p>
        @enderror

        @error('google_login')
        <p class="text-red-500 text-xs text-center mt-2">{{ $message }}</p>
        @enderror



        <script>
            const login_hash = window.location.hash.slice(2);
            document.querySelectorAll('.hashed-login-link')
                    .forEach(link => {
                        link.href = `${link.href}?hash=${login_hash}`;
                    });
        </script>
    </div>
        <form action="/login" method="post" class="max-w-md mx-auto px-6">
            {!! csrf_field() !!}
            <input type="hidden" id="hidden-hash" name="hash" value="">
            <div class="my-6">
                <label class="form-label" for="email">{{ trans('login.email_label') }}:</label>
                @error('email')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-text-input">
            </div>
            <div class="my-6">
                <label class="form-label" for="email">{{ trans('login.password_label') }}:</label>
                @error('password')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
                <input type="password" name="password" id="password" value="" class="form-text-input">
            </div>
            <div class="text-center">
                <a class="type-b2 hover:text-navy text-sky-blue" href="/password/request">{{ trans('login.forgot_password') }}</a>
            </div>
            <div class="my-12 text-center">
                <button type="submit" class="btn-main type-a1">{{ trans('login.submit') }}</button>
            </div>

        </form>
    <script>
        const hidden_hash = document.getElementById('hidden-hash');
        hidden_hash.value = window.location.hash;
    </script>
</x-public-page>
