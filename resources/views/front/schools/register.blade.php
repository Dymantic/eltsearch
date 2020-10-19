<x-public-page title="Signup for ELTSearch">
        <div class="my-20 text-center">
            <h1 class="type-h2 text-navy mb-8 max-w-3xl mx-auto">Sign up to post jobs ELT Search</h1>
            <p class="type-b1 mt-4">Already a member? <a href="/login" class="type-b2 text-sky-blue hover:text-navy ">Sign in</a>
            </p>
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

            <div class="my-6">
                <p class="form-label">What is your preferred language?</p>
                <div class="flex justify-between mt-2">
                    <div>
                        <label for="lang_zh" class="flex items-center">
                            <span>Chinese</span>
                            <input type="radio" name="preferred_lang" value="zh" id="lang_zh" class="hidden">
                            <span class="custom-check"></span>
                        </label>
                    </div>
                    <div>
                        <label for="lang_en" class="flex items-center">
                            <span>English</span>
                            <input type="radio" name="preferred_lang" value="en" id="lang_en" class="hidden">
                            <span class="custom-check"></span>
                        </label>
                    </div>
                </div>
                <script>
                    window.addEventListener('load', () => {
                        if(navigator && navigator.language.includes('zh')) {
                            const el = document.getElementById('lang_zh');
                            el.checked = true;
                        }
                        if(navigator && navigator.language.includes('en')) {
                            const el = document.getElementById('lang_en');
                            el.checked = true;
                        }
                    })
                </script>
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
