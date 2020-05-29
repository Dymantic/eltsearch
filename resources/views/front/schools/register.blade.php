<x-public-page title="Signup for ELTSearch">
    <div>
        <h1>Signup now and and get dem teachers</h1>
        <form action="/register/school" method="post">
            {!! csrf_field() !!}
            <div>
                <label for="name">Your name:</label>
                @error('name')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
                <input type="text" name="name" id="name" class="block border" value="{{ old('name') }}">
            </div>
            <div>
                @error('email')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
                <label for="email">Email address:</label>
                <input type="email" name="email" id="email" class="block border" value="{{ old('email') }}">
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
                <label for="school_name">Your schools name:</label>
                @error('school_name')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
                <input type="text" id="school_name" value="{{ old('school_name') }}" name="school_name" class="block border">
            </div>
            <div>
                <label for="school_address">Your schools address:</label>
                @error('school_address')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
                <input type="text" id="school_address" value="{{ old('school_address') }}" name="school_address" class="block border">
            </div>
            <div>
                <button type="submit">Sign Up</button>
            </div>
        </form>
    </div>
</x-public-page>
