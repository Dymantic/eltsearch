<x-public-page>
    <div>
        <h1>Please login</h1>
        <form action="/login" method="post">
            {!! csrf_field() !!}
            <div>
                <label for="email">Your email address:</label>
                @error('email')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="border block">
            </div>
            <div>
                <label for="email">Your password:</label>
                @error('password')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
                <input type="password" name="password" id="password" value="" class="border block">
            </div>
            <div>
                <button type="submit">Login</button>
            </div>
            <div>
                <a href="/password/request">I have forgotten my password</a>
            </div>
        </form>
    </div>
</x-public-page>
