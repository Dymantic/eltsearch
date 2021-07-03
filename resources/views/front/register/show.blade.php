<x-public-page title="Signup for ELTSearch" :dontIndex="true">

    <div class="max-w-5xl mx-auto px-6 py-20"
         x-data="registerPage()"
         x-cloak
         x-init="init">
        <div class=""
             x-show="showChoice">
            <p class="type-h2 text-navy mb-8 text-center">{{ trans('registration.heading') }}</p>
            <p class="type-h3 text-gray-700 mb-12 text-center">{{ trans('registration.intro') }}</p>
            <div class="flex flex-col md:flex-row justify-center mx-auto">
                <a href="#teachers"
                   @click="showTeachers()"
                   class="md:mx-12 mb-8 md:mb-0 block w-full md:w-1/2">
                    <div class="bg-sky-blue hover:bg-navy text-white rounded-lg shadow-lg p-6 text-center">
                        <div class="flex justify-center">
                            @include('svg.icons.teachers', ['classes' => 'h-6'])
                        </div>
                        <p class="type-h3 my-2">{{ trans('registration.for_teachers.title') }}</p>
                        <p>{{ trans('registration.for_teachers.text') }}</p>
                    </div>
                </a>
                <a href="#schools"
                   @click="showSchools()"
                   class="md:mx-12 mb-8 md:mb-0 block w-full md:w-1/2">
                    <div class="bg-sky-blue hover:bg-navy text-white rounded-lg shadow-lg p-6 text-center">
                        <div class="flex justify-center">
                            @include('svg.icons.school', ['classes' => 'h-6'])
                        </div>
                        <p class="type-h3 my-2">{{ trans('registration.for_schools.title') }}</p>
                        <p>{{ trans('registration.for_schools.text') }}</p>
                    </div>
                </a>
            </div>

            <div></div>
        </div>
        <div x-show="showTeachersForm">
            @include('front.register.teachers-form')
        </div>
        <div x-show="showSchoolsForm">
            @include('front.register.schools-form')
        </div>

        <div class="max-w-3xl mx-auto text-center my-20">
            <p class="type-b1 mt-4">{{ trans('registration.schools.agree') }} <a href=""
                                                                                 class="type-b2 text-sky-blue hover:text-navy ">{{ trans('registration.schools.terms') }}</a>
        </div>
    </div>

    <script>
        function registerPage() {
            return {
                showTeachersForm: false,
                showSchoolsForm: false,
                showChoice: true,
                lang: 'en',
                showTeachers() {
                    this.showTeachersForm = true;
                    this.showSchoolsForm = false;
                    this.showChoice = false;
                },
                showSchools() {
                    this.showSchoolsForm = true;
                    this.showTeachersForm = false;
                    this.showChoice = false;
                },
                reset() {
                    this.showSchoolsForm = false;
                    this.showTeachersForm = false;
                    this.showChoice = true;
                },
                checkHash() {
                    const hash = window.location.hash;

                    if (!hash) {
                        return this.reset();
                    }

                    if (hash.includes('teachers')) {
                        return this.showTeachers();
                    }

                    if (hash.includes('schools')) {
                        return this.showSchools();
                    }
                },
                init() {
                    this.checkHash();
                    window.addEventListener('popstate', () => this.checkHash());

                    if(navigator && navigator.language.includes('zh')) {
                        this.lang = 'zh';
                    }
                }
            };
        }
    </script>
    @push('head_scripts')
        <script src="https://www.google.com/recaptcha/api.js?render={{ $recaptcha_key }}"></script>
    @endpush
</x-public-page>
