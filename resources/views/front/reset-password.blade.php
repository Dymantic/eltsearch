<x-public-page>
    <div class="my-20 px-6 max-w-3xl mx-auto text-center">
        <h1 class="type-h2 text-navy mb-12">Choose a new password</h1>
        <p class="max-w-xl mx-auto type-b1">Fill in the email address you used to sign up, and choose a new password. We will then log you back in and it will be like you never left.</p>
    </div>

    <form action="/password/reset" method="post" class="max-w-md mx-auto">
        {!! csrf_field() !!}
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="my-6">
            <label class="form-label" for="email">Your email address:</label>
            @error('email')
            <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
            <input type="email" name="email" id="email" value="{{ $email }}" class="form-text-input">
        </div>
        <div class="my-6">
            <label class="form-label" for="password">Choose a password:</label>
            @error('password')
            <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
            <input type="password" id="password" name="password" class="form-text-input">
        </div>
        <div class="my-6">
            <label class="form-label" for="password_confirmation">Confirm your password:</label>

            <input type="password" id="password_confirmation" name="password_confirmation" class="form-text-input">
        </div>
        <div class="my-12 text-center">
            <button type="submit" class="btn-main type-a1">Sign Up</button>
        </div>
    </form>
</x-public-page>
