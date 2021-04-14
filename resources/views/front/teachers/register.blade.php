<x-public-page title="Signup for ELTSearch" :dontIndex="true">
    <div class="my-20 px-6 text-center">
        <h1 class="type-h2 text-navy mb-8">Sign up to find jobs on ELT Search</h1>
        <p class="max-w-3xl mx-auto type-b1">This is for teachers to sign up. Are you a school looking to post jobs? Then
            <a
                href="/register/school"
                class="type-b2 text-sky-blue hover:text-navy">sign up here.</a></p>

    </div>

    <div class="mb-12 px-6">
        <x-facebook-login redirect="/register/teacher/facebook"></x-facebook-login>
    </div>

    <p class="px-6 type-b3 my-4 text-center">Already a member? <a href=""
                                                                  class="type-b4 text-sky-blue hover:text-navy ">Sign in</a>

    <form action="/register/teacher"
          method="post"
          class="max-w-md mx-auto px-6">
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

    <div class="max-w-3xl mx-auto text-center mb-20 px-6">
        <p class="type-b1 mt-4">By signing up you agree to the <a href="/terms-of-service"
                                                                  class="type-b2 text-sky-blue hover:text-navy ">ELT Search Terms & Conditions</a>
    </div>
</x-public-page>
