<div class="main-nav bg-white fixed top-0 left-0 z-50 w-screen py-1 px-6 flex flex-col lg:flex-row lg:justify-between lg:items-center h-16 shadow">
    <a href="/" class="text-navy hover:text-sky-blue">
        @include('svg.logos.full_logo_2', ['classes' => 'h-8'])
    </a>
    <div class="sub-nav text-navy bg-white left-0 pt-12 lg:pt-0 pl-6 lg:pl-0 fixed top-16 w-screen lg:w-auto h-screen lg:h-16 lg:static flex flex-col lg:flex-row lg:items-center">
        <div class="flex flex-col lg:flex-row lg:items-center">
            <div class="type-b2 pl-4 lg:pl-0 mr-4 mb-4 lg:mb-0"><a class="hover:text-sky-blue" href="/job-posts">Find Jobs</a></div>
            <div class="type-b2 pl-4 lg:pl-0 mr-4 mb-4 lg:mb-0"><a class="hover:text-sky-blue" href="/how-it-works">How It Works</a></div>
            <div class="type-b2 pl-4 lg:pl-0 mr-4 mb-4 lg:mb-0"><a class="text-gray-600 hover:text-sky-blue" href="/for-schools">For Schools</a></div>
        </div>
        <div class="lg:border-l border-gray-400 flex flex-col lg:flex-row lg:items-center">
            @auth
                <div class="type-b2 pl-4 lg:pl-0 mx-0 lg:mx-6 mb-4 lg:mb-0"><a class="hover:text-sky-blue" href="{{ $dashboard_url }}">Dashboard</a></div>
                <form method="POST" action="/logout">
                    {!! csrf_field() !!}
                    <button type="submit" class="type-b2 " href="/register/teacher">Logout</button>
                </form>
            @endauth
            @guest
                <div class="type-b2 pl-4 lg:pl-0 mx-0 lg:mx-6 mb-4 lg:mb-0"><a class="hover:text-sky-blue" href="/login">Sign in</a></div>
                <div><a class="type-b2 btn-main" href="/register/teacher">Sign up</a></div>
            @endguest

        </div>
    </div>
    <button class="nav-trigger absolute top-0 right-0 m-3 lg:hidden">menu</button>
</div>
