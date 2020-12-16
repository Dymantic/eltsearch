<div class="main-nav bg-white fixed top-0 left-0 z-50 w-screen py-1 px-6 flex lg:justify-between items-center h-16 shadow">
    <a href="/" class="text-navy hover:text-sky-blue">
        @include('svg.logos.full_logo', ['classes' => 'h-8 text-navy'])
    </a>
    <div class="flex justify-end items-center flex-1">
        <div class="sub-nav text-navy bg-white left-0 pt-12 lg:pt-0 pl-6 lg:pl-0 fixed top-16 w-screen lg:w-auto h-screen lg:h-16 lg:static flex flex-col lg:flex-row lg:items-center">
            <div class="flex flex-col lg:flex-row lg:items-center">
                <div class="type-b2 pl-4 lg:pl-0 mr-4 mb-4 lg:mb-0"><a class="hover:text-sky-blue" href="/job-posts">{{ trans('nav.find_jobs') }}</a></div>
                <div class="type-b2 pl-4 lg:pl-0 mr-4 mb-4 lg:mb-0"><a class="hover:text-sky-blue" href="/how-it-works">{{ trans('nav.how_it_works') }}</a></div>
                <div class="type-b2 pl-4 lg:pl-0 mr-4 mb-4 lg:mb-0"><a class="text-gray-600 hover:text-sky-blue" href="/for-schools">{{ trans('nav.for_schools') }}</a></div>
            </div>
            <div class="lg:border-l border-gray-400 flex flex-col lg:flex-row lg:items-center">
                @auth
                    <div class="type-b2 pl-4 lg:pl-0 mx-0 lg:mx-6 mb-4 lg:mb-0"><a class="hover:text-sky-blue" href="{{ $dashboard_url }}">Dashboard</a></div>
                    <form method="POST" action="/logout" class="pl-4">
                        {!! csrf_field() !!}
                        <button type="submit" class="type-b2 " href="/register/teacher">Logout</button>
                    </form>
                @endauth
                @guest
                    <div class="type-b2 pl-4 lg:pl-0 mx-0 lg:mx-6 mb-4 lg:mb-0"><a class="hover:text-sky-blue" href="/login">{{ trans('nav.sign_in') }}</a></div>
                    <div><a class="type-b2 btn-main" href="/register/teacher">{{ trans('nav.sign_up') }}</a></div>
                @endguest

            </div>

        </div>
        <a href="{{ $translatedUrl(Request::path()) }}" class="ml-4 text-navy hover:text-sky-blue">{{ trans('nav.lang') }}</a>
        <button class="nav-trigger ml-4 lg:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="fill-current h-5">
                <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"/>
            </svg>
        </button>
    </div>


</div>
