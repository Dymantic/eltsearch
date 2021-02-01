<x-public-page title="Signup for ELTSearch">

    <div class="max-w-5xl mx-auto px-6 py-20"
         x-data="registerPage()"
         x-cloak
         x-init="init">
        <div class=""
             x-show="showChoice">
            <p class="type-h2 text-navy mb-20 text-center">Start your voyage with ELT Search</p>
            <div class="flex flex-col md:flex-row justify-center mx-auto">
                <a href="#teachers"
                   @click="showTeachers()"
                   class="md:mx-12 mb-8 md:mb-0 block w-full md:w-1/2 hover:bg-blue-100">
                    <div class="shadow border border-sky-blue p-6 text-center">
                        <p class="type-h3 mb-3 text-navy">For Teachers</p>
                        <p>Sign up to find the best job for you! Get notified when new jobs become available that match your search criteria.</p>
                    </div>
                </a>
                <a href="#schools"
                   @click="showSchools()"
                   class="md:mx-12 mb-8 md:mb-0 block w-full md:w-1/2 hover:bg-blue-100">
                    <div class="shadow flex-1 border border-sky-blue p-6 text-center">
                        <p class="type-h3 mb-3 text-navy">For Schools</p>
                        <p>Sign up to find the best teachers for your school! Post jobs and see profiles of the thousands of teachers active on ELT Search.</p>
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

</x-public-page>
