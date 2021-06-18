<footer class="bg-navy relative text-white px-6">
{{--    @include('svg.logos.icon_logo', ['classes' => 'hidden lg:block absolute text-white h-24 ml-4 left-0 top-50 transform -translate-y-1/2'])--}}
    @include('svg.logos.icon_logo', ['classes' => 'absolute text-white opacity-10 h-64 right-16 top-50 -translate-y-1/2 transform'])
    <div class="grid grid-cols-1 md:grid-cols-3 gap-12 max-w-3xl mx-auto justify-center pt-20">
        <div class="text-center lg:text-left">
            <p class="type-h3 mb-3">{{ trans('footer.teachers') }}</p>
            <p class="type-h4">
                <a class="hover:text-sky-blue"
                   href="/register/teacher">
                    {{ trans('footer.sign_up') }}
                </a>
            </p>
            <p class="type-h4">
                <a class="hover:text-sky-blue"
                   href="/job-posts">
                    {{ trans('footer.find_jobs') }}
                </a>
            </p>
            <p class="type-h4">
                <a class="hover:text-sky-blue"
                   href="/how-it-works">
                    {{ trans('footer.how_it_works') }}
                </a>
            </p>
        </div>
        <div class="text-center">
            <a href="/"
               class="hover:text-sky-blue">
                @include('svg.icons.facebook_circle', ['classes' => 'h-10 mx-auto'])
            </a>
            <p class="type-b2 w-32 mx-auto mt-3"><a href="https://www.facebook.com/groups/TaiwanTeachingJobs" target="_blank" rel="nofollow">{{ trans('footer.facebook_community') }}</a></p>

        </div>
        <div class="text-center lg:text-left lg:pl-20">
            <p class="type-h3 mb-3">{{ trans('footer.schools') }}</p>
            <p class="type-h4"><a class="hover:text-sky-blue"
                                  href="/register/school">{{ trans('footer.sign_up') }}</a></p>
            <p class="type-h4"><a class="hover:text-sky-blue"
                                  href="/for-schools">{{ trans('footer.how_it_works') }}</a></p>
        </div>
    </div>
    <div class="mt-8">
        <p class="type-b1 text-center">{{ trans('footer.already_member') }} <a href="/login"
                                                                               class="type-b2 hover:text-sky-blue">{{ trans('footer.log_in') }}</a>
        </p>
    </div>
    <div class="py-8 flex flex-col lg:flex-row justify-center items-center">
        <a href="/terms-of-service"
           class="hover:text-sky-blue type-b2">{{ trans('footer.terms_of_service') }}</a>
        <span class="hidden lg:block mx-4 text-white">|</span>
        <a href="/privacy-policy"
           class="hover:text-sky-blue type-b2">{{ trans('footer.privacy_policy') }}</a>
        <span class="hidden lg:block mx-4 text-white">|</span>
        <a href="/delivery-policy"
           class="hover:text-sky-blue type-b2">{{ trans('footer.delivery_policy') }}</a>
        <span class="hidden lg:block mx-4 text-white">|</span>
        <a href="/refund-policy"
           class="hover:text-sky-blue type-b2">{{ trans('footer.refund_policy') }}</a>
        <span class="hidden lg:block mx-4 text-white">|</span>
        <a href="/contact"
           class="hover:text-sky-blue type-b2">{{ trans('footer.contact_us') }}</a>
    </div>
    <p class="type-b2 text-center py-1">&copy; {{ trans('footer.registered') }} {{ now()->year }}. {{ trans('footer.built_by') }}
        <a href="https://dymanticdesign.com"
           target="_blank" rel="nofollow"
           class="hover:text-odd-pink">{{ trans('footer.dymantic') }}</a></p>
</footer>
