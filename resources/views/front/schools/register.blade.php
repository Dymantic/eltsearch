<x-public-page title="Signup for ELTSearch">
        <div class="my-20 text-center">
            <h1 class="type-h2 text-navy mb-8 max-w-3xl mx-auto">Sign up to post jobs ELT Search</h1>
            <p class="type-b1 mt-4">Already a member? <a href="" class="type-b2 text-sky-blue hover:text-navy ">Sign in</a>
            </p>
        </div>

        <div class="mb-12">
            <div class="flex max-w-sm mx-auto rounded-lg overflow-hidden">
                <div class="flex justify-center items-center bg-medium-gray p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="fill-current text-navy h-8"><path d="M17 1H3c-1.1 0-2 .9-2 2v14c0 1.101.9 2 2 2h7v-7H8V9.525h2v-2.05c0-2.164 1.212-3.684 3.766-3.684l1.803.002v2.605h-1.197c-.994 0-1.372.746-1.372 1.438v1.69h2.568L15 12h-2v7h4c1.1 0 2-.899 2-2V3c0-1.1-.9-2-2-2z"/></svg>
                </div>
                <div class="flex-1 text-center flex justify-center items-center ml-1 bg-medium-gray">
                    <p>Sign Up with Facebook</p>
                </div>
            </div>
        </div>

        <form action="/register/school" method="post" class="max-w-md mx-auto">
            {!! csrf_field() !!}
            <div class="my-6">
                <label class="form-label" for="name">Your name:</label>
                @error('name')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
                <input type="text" name="name" id="name" class="form-text-input" value="{{ old('name') }}">
            </div>
            <div class="my-6">
                @error('email')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
                <label class="form-label" for="email">Email address:</label>
                <input type="email" name="email" id="email" class="form-text-input" value="{{ old('email') }}">
            </div>

            <div class="my-6">
                <label class="form-label" for="school_name">Your schools name:</label>
                @error('school_name')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
                <input type="text" id="school_name" value="{{ old('school_name') }}" name="school_name" class="form-text-input">
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

        <div class="max-w-3xl mx-auto text-center mb-20">
            <p class="type-b1 mt-4">By signing up you agree to the <a href=""
                                                                      class="type-b2 text-sky-blue hover:text-navy ">ELT
                    Search Terms & Conditions</a>
        </div>

</x-public-page>
