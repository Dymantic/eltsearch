<x-public-page>
    <div class="my-20 text-center">
        <h1 class="type-h2 text-navy mb-8 max-w-3xl mx-auto">Sign in to your ELT Search account</h1>

    </div>

    <div class="mb-12">
        <x-facebook-login redirect="/login/facebook"></x-facebook-login>
        @error('facebook_login')
        <p class="text-red-500 text-xs text-center mt-2">{{ $message }}</p>
        @enderror
    </div>
        <form action="/login" method="post" class="max-w-md mx-auto">
            {!! csrf_field() !!}
            <div class="my-6">
                <label class="form-label" for="email">Your email address:</label>
                @error('email')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-text-input">
            </div>
            <div class="my-6">
                <label class="form-label" for="email">Your password:</label>
                @error('password')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
                <input type="password" name="password" id="password" value="" class="form-text-input">
            </div>
            <div class="text-center">
                <a class="type-b2 hover:text-navy text-sky-blue" href="/password/request">I have forgotten my password</a>
            </div>
            <div class="my-12 text-center">
                <button type="submit" class="btn-main type-a1">Login</button>
            </div>

        </form>
</x-public-page>
