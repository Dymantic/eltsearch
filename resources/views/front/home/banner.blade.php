<div class="py-12 lg:py-20 px-6 border-b border-navy">
    @include('svg.logos.icon_logo', ['classes' => 'text-navy h-40 block mx-auto'])
    <h1 class="mt-6 text-navy type-h1 text-center leading-none">Welcome to<br class="lg:hidden"> ELT Search
    </h1>
    <p class="type-h3 text-navy text-center mt-3 leading-tight">{{ trans('homepage.banner.sub_heading') }}</p>
    <div class="my-6">
        <p class="text-navy max-w-2xl mx-auto mb-3 text-center type-b1">{{ trans('homepage.banner.blurb_one') }}<br>{{ trans('homepage.banner.blurb_two') }}</p>
        <p class="text-navy max-w-xl mx-auto text-center type-b1"></p>
    </div>
    <div class="my-12 text-center">
        <a href="" class="btn-main type-a1">{{ trans('homepage.banner.button') }}</a>
        <p class="type-b1 mt-4">{{ trans('homepage.banner.already_member') }} <a href="/login" class="type-b2 text-sky-blue hover:text-navy ">{{ trans('homepage.banner.sign_in') }}</a>
        </p>

    </div>
</div>
