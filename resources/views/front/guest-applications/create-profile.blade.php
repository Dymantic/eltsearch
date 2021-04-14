<x-public-page :dontIndex="true">
    <div class="py-20 px-6 max-w-5xl mx-auto">
        <p class="type-h3 text-gray-600 text-center">Job Application for {{ $post['school_name'] }}</p>
        <x-step-header :step="1" :of="4"></x-step-header>
        <p class="max-w-lg mx-auto my-6">Provide a bit of info about yourself. This will be used to fill out your application, as well as create your free profile on ELT Search. You can always kep your profile private, should you choose.</p>

        <form action="/guest-applications/profile"
              method="post">
            {!! csrf_field() !!}
            @if(count($errors->all()))
                <p class="my-6 text-center text-red-600">Some of your input is not valid. Please correct it, and try again.</p>
            @endif

            <div class="max-w-lg mx-auto mb-12">
                <p class="type-a1 text-navy">Account details</p>
                <x-input-field class="my-6"
                               name="name"
                               :error="$errors->first('name')"
                               value="{{ old('name') }}"
                               label="Your name">
                </x-input-field>

                <x-input-field class="my-6"
                               name="email"
                               type="email"
                               :error="$errors->first('email')"
                               value="{{ old('email') || $email }}"
                               help-text="This is the email address that will be used to log in, and for ELT Search to contact you if neccessary. It does not have to be the same email address you give to the school in your application."
                               label="Your Email address">
                </x-input-field>

                <x-input-field class="my-6"
                               name="password"
                               type="password"
                               :error="$errors->first('password')"
                               value=""
                               help-text="Choose a password to use when logging in later."
                               label="Password">
                </x-input-field>

                <x-input-field class="my-6"
                               name="password_confirmation"
                               type="password"
                               value=""
                               label="Confirm Your Password">
                </x-input-field>
            </div>

            <div class="max-w-lg mx-auto mb-12">
                <p class="type-a1 text-navy">About you</p>
                <x-input-field class="my-6"
                               name="years_experience"
                               type="number"
                               :error="$errors->first('years_experience')"
                               value="{{ old('years_experience') }}"
                               label="Years of Teaching Experience">
                </x-input-field>

                <x-select-field class="my-6"
                                :options="$nations"
                                name="nation_id"
                                :error="$errors->first('nation_id')"
                                value="{{ old('nation_id') }}"
                                prompt=""
                                label="Your Nationality"></x-select-field>

                <x-input-field class="my-6"
                               name="date_of_birth"
                               :error="$errors->first('date_of_birth')"
                               value="{{ old('date_of_birth') }}"
                               help-text="Please enter your date of birth as follows: YYYY-MM-DD"
                               label="Date of Birth">
                </x-input-field>

                <x-input-field class="my-6"
                               name="native_language"
                               :error="$errors->first('native_language')"
                               value="{{ old('native_language') }}"
                               label="Your native language">
                </x-input-field>

                <x-input-field class="my-6"
                               name="other_languages"
                               :error="$errors->first('other_languages')"
                               value="{{ old('other_languages') }}"
                               help-text="List any other languages which you can speak confidently."
                               label="Other spoken languages">
                </x-input-field>
            </div>

            <div class="max-w-lg mx-auto mb-12">
                <p class="type-a1 text-navy">Your education</p>
                <x-select-field class="my-6"
                                :options="$education_levels"
                                name="education_level"
                                :error="$errors->first('education_level')"
                                value="{{ old('education_level') }}"
                                prompt=""
                                label="Your Highest Level of Education"></x-select-field>

                <x-input-field class="my-6"
                               name="education_qualification"
                               :error="$errors->first('education_qualification')"
                               value="{{ old('education_qualification') }}"
                               help-text="What is your highest diploma/qualification/degree"
                               label="Degree"></x-input-field>

                <x-input-field class="my-6"
                               name="education_institution"
                               :error="$errors->first('education_institution')"
                               value="{{ old('education_institution') }}"
                               help-text="Where did you get your highest level of education (name of college,university, etc.)"
                               label="Place of education">
                </x-input-field>
            </div>

            <div class="max-w-lg mx-auto my-12">
                <button class="btn-main" type="submit">Next Step &rarr;</button>
            </div>






        </form>
    </div>
</x-public-page>
