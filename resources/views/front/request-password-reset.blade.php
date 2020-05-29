<x-public-page>
    <div>
        <h1>Don't feel bad! We'll help you right out!</h1>
        <p>Just enter the email you used to sign up and we will send you a link to that address. Follow the link to reset your password.</p>
        <div>
            <form action="/password/request" method="post">
                {!! csrf_field() !!}
                <div>
                    <label for="email">Your email address:</label>
                    @error('email')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="border block">
                </div>
                <div>
                    <button type="submit">Request link</button>
                </div>
            </form>
        </div>
    </div>
</x-public-page>
