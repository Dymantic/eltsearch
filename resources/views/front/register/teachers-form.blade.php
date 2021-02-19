<h1 class="type-h2 text-center text-navy mb-8">Sign up to find jobs on ELT Search</h1>
<p class="max-w-3xl mx-auto type-b1 text-center mb-12">This is for teachers to sign up. Are you a school looking to post jobs? Then
    <a
        href="#schools"
        class="type-b2 text-sky-blue hover:text-navy">sign up here.</a></p>


<div class="mb-12 px-6">
    <div class="flex flex-col justify-center items-center">
        <div class="my-4">
            <x-facebook-login text="Sign in with Facebook" redirect="/login/facebook"></x-facebook-login>
        </div>
        <div class="my-4">
            <x-google-login redirect="/login/google" text="Sign in with Google"></x-google-login>
        </div>
    </div>
</div>

@include('front.register.already-member')

<form action="/register/teacher"
      method="post"
      class="max-w-md mx-auto">
    {!! csrf_field() !!}
    <div class="my-6">
        <label class="form-label"
               for="name">Your name:</label>
        @error('name')
        <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
        <input type="text"
               name="name"
               id="name"
               class="form-text-input"
               value="{{ old('name') }}">
    </div>
    <div class="my-6">
        @error('email')
        <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
        <label class="form-label"
               for="email">Email address:</label>
        <input type="email"
               name="email"
               id="email"
               class="form-text-input"
               value="{{ old('email') }}">
    </div>
    <div class="my-6">
        <label class="form-label"
               for="password">Choose a password:</label>
        @error('password')
        <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
        <input type="password"
               id="password"
               name="password"
               class="form-text-input">
    </div>
    <div class="my-6">
        <label class="form-label"
               for="password_confirmation">Confirm your password:</label>

        <input type="password"
               id="password_confirmation"
               name="password_confirmation"
               class="form-text-input">
    </div>
    <div class="text-center my-12">
        <button class="btn-main type-a1"
                type="submit">Sign Up
        </button>
    </div>

</form>
