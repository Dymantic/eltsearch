<x-public-page>
    <h1>Chose a new password</h1>
    <p>Fill in your email address, choose a new password, and we will log you back in.</p>
    <form action="/password/reset" method="post">
        {!! csrf_field() !!}
        <input type="hidden" name="token" value="{{ $token }}">
        <div>
            <label for="email">Your email address:</label>
            @error('email')
            <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
            <input type="email" name="email" id="email" value="{{ $email }}" class="border block">
        </div>
        <div>
            <label for="password">Choose a password:</label>
            @error('password')
            <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
            <input type="password" id="password" name="password" class="block border">
        </div>
        <div>
            <label for="password_confirmation">Confirm your password:</label>

            <input type="password" id="password_confirmation" name="password_confirmation" class="block border">
        </div>
        <div>
            <button type="submit">Sign Up</button>
        </div>
    </form>
</x-public-page>
