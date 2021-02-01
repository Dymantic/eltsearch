<div class="main-nav bg-white fixed top-0 left-0 z-50 w-screen py-1 px-6 flex flex-col lg:flex-row lg:justify-between lg:items-center h-16 shadow">
    <a href="/" class="text-navy hover:text-sky-blue">
        @include('svg.logos.full_logo_2', ['classes' => 'h-8'])
    </a>
    <div class="sub-nav text-navy bg-white left-0 pt-12 lg:pt-0 pl-6 lg:pl-0 fixed top-16 w-screen lg:w-auto h-screen lg:h-16 lg:static flex flex-col lg:flex-row lg:items-center">
        <div class="flex flex-col lg:flex-row lg:items-center">
            <div class="type-b2 pl-4 lg:pl-0 mr-4 mb-4 lg:mb-0"><a class="hover:text-sky-blue" href="/job-posts">{{ trans('nav.find_jobs') }}</a></div>
            <div class="type-b2 pl-4 lg:pl-0 mr-4 mb-4 lg:mb-0"><a class="hover:text-sky-blue" href="/how-it-works">{{ trans('nav.how_it_works') }}</a></div>
            <div class="type-b2 pl-4 lg:pl-0 mr-4 mb-4 lg:mb-0"><a class="text-gray-600 hover:text-sky-blue" href="/for-schools">{{ trans('nav.for_schools') }}</a></div>
        </div>
        <div class="lg:border-l border-gray-400 flex flex-col lg:flex-row lg:items-center">
            @auth
                <div class="type-b2 pl-4 lg:pl-0 mx-0 lg:mx-6 mb-4 lg:mb-0"><a class="hover:text-sky-blue" href="/teachers">My Account</a></div>
                <div><a class="type-b2 " href="/register/teacher">Logout</a></div>
            @endauth
            @guest
                    <div class="type-b2 pl-4 lg:pl-0 mx-0 lg:mx-6 mb-4 lg:mb-0"><a class="hover:text-sky-blue" href="/login">{{ trans('nav.sign_in') }}</a></div>
                    <div><a class="type-b2 btn-main" href="/register/teacher">{{ trans('nav.sign_up') }}</a></div>
            @endguest

        </div>
    </div>
    <button class="nav-trigger absolute top-0 right-0 m-3 lg:hidden">menu</button>
</div>
