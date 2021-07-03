<div class="mb-20 text-center">
    <h1 class="type-h2 text-navy mb-8 max-w-3xl mx-auto">{{ trans('registration.schools.title') }}</h1>

    <p class="max-w-3xl mx-auto type-b1 text-center mb-12">This is for schools to sign up. Are you an English teacher looking for jobs? Then
        <a
            href="#teachers"
            class="type-b2 text-sky-blue hover:text-navy">sign up here.</a></p>

    @include('front.register.already-member')
</div>

<form action="/register/school" method="post" class="max-w-md mx-auto" id="school-form">
    {!! csrf_field() !!}
    <div class="my-6">
        <label class="form-label" for="school_name">{{ trans('registration.schools.name') }}:</label>
        @error('name')
        <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
        <input type="text" name="name" id="school_name" class="form-text-input" value="{{ old('name') }}">
    </div>
    <div class="my-6">
        @error('email')
        <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
        <label class="form-label" for="school_email">{{ trans('registration.schools.email') }}:</label>
        <input type="email" name="email" id="school_email" class="form-text-input" value="{{ old('email') }}">
    </div>

    <div class="my-6">
        <label class="form-label" for="school_school_name">{{ trans('registration.schools.school') }}:</label>
        @error('school_name')
        <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
        <input type="text" id="school_school_name" value="{{ old('school_name') }}" name="school_name" class="form-text-input">
    </div>

    <div class="my-6">
        <label class="form-label" for="school_password">{{ trans('registration.schools.choose_password') }}:</label>
        @error('password')
        <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
        <input type="password" id="school_password" name="password" class="form-text-input">
    </div>
    <div class="my-6">
        <label class="form-label" for="school_password_confirmation">{{ trans('registration.schools.confirm_password') }}:</label>

        <input type="password" id="school_password_confirmation" name="password_confirmation" class="form-text-input">
    </div>

    <div class="my-6">
        <p class="form-label">{{ trans('registration.schools.preferred_lang') }}</p>
        <div class="flex justify-between mt-2">
            <div>
                <label for="lang_zh" class="flex items-center">
                    <span>{{ trans('registration.schools.chinese') }}</span>
                    <input  :checked="lang === 'zh'" type="radio" name="preferred_lang" value="zh" id="lang_zh" class="hidden">
                    <span class="custom-check"></span>
                </label>
            </div>
            <div>
                <label for="lang_en" class="flex items-center">
                    <span>{{ trans('registration.schools.english') }}</span>
                    <input :checked="lang === 'en'" type="radio" name="preferred_lang" value="en" id="lang_en" class="hidden">
                    <span class="custom-check"></span>
                </label>
            </div>
        </div>

    </div>
    <input type="hidden" id="school_recaptcha_token" name="recaptcha_token" value="">
    <div class="my-12 text-center">
        <button type="submit"
                class="btn-main type-a1 g-recaptcha"
                data-sitekey="{{ $recaptcha_key }}"
                data-callback="onSchoolRegister"
                data-action="submit"
        >{{ trans('registration.schools.submit') }}</button>
    </div>
</form>


<script>

    function onSchoolRegister(token) {
        const form = document.querySelector('#school-form');
        const input = document.querySelector('#school_recaptcha_token');
        input.value = token;
        form.submit();
    }
</script>
