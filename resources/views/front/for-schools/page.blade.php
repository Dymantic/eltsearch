<x-public-page :dontIndex="true">
    <div class="my-20 px-6 max-w-3xl mx-auto text-center">
        <h1 class="type-h2 text-navy mb-12">{{ trans('for_schools.banner.heading') }}</h1>
        <p class="max-w-xl mx-auto type-b1">{{ trans('for_schools.banner.blurb') }}</p>
    </div>

    <div class="mx-auto px-6">
        <p class="type-h6 text-navy max-w-3xl mx-auto mb-10">{{ trans('for_schools.why_use.heading') }}</p>
        <div class="max-w-4xl mx-auto flex justify-center flex-wrap">
            <x-iconed-card :title="trans('for_schools.why_use.one.heading')" icon="sign-up">{{ trans('for_schools.why_use.one.text') }}</x-iconed-card>

            <x-iconed-card :title="trans('for_schools.why_use.two.heading')" icon="global">{{ trans('for_schools.why_use.two.text') }}</x-iconed-card>

            <x-iconed-card :title="trans('for_schools.why_use.three.heading')" icon="database">{{ trans('for_schools.why_use.three.text') }}</x-iconed-card>

            <x-iconed-card :title="trans('for_schools.why_use.four.heading')" icon="supply">{{ trans('for_schools.why_use.four.text') }}</x-iconed-card>

            <x-iconed-card :title="trans('for_schools.why_use.five.heading')" icon="dashboard">{{ trans('for_schools.why_use.five.text') }}</x-iconed-card>

            <x-iconed-card :title="trans('for_schools.why_use.six.heading')" icon="ts_cs">{{ trans('for_schools.why_use.six.text') }}</x-iconed-card>
        </div>
    </div>

    <div class="my-20 px-6">
        <p class="type-h6 text-navy max-w-3xl mx-auto mb-10">{{ trans('for_schools.pricing.heading') }}</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-16 max-w-3xl mx-auto">
            @foreach($packages as $package)
                <div class="w-full shadow-lg mx-auto my-8">
                    <div class="text-sky-blue bg-baby-blue py-3 text-center shadow">
                        @if($package['icon'])
                            <div class="h-8 flex items-center justify-center my-1">
                                @include($package['icon'], ['classes' => $package['icon_size'] . ' text-sky-blue block mx-auto'])
                            </div>
                        @endif
                        <p class="type-h3">
                            {{ $package['name'] }}
                        </p>

                    </div>
                    <div class="p-4 text-center">
                        <p class="type-b2">{{ $package['price'] }}</p>
                        @foreach($package['selling_points'] as $point)
                        <p class="type-b1">{{ $point }}</p>
                        @endforeach
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    <p class="my-16 max-w-xl mx-auto type-h4 text-navy text-center px-6">{{ trans('for_schools.outro.sign_up_prompt') }}</p>

    <div class="text-center mb-20 px-6">
        <a href="/register#schools" class="btn-main type-a1">{{ trans('for_schools.outro.button') }}</a>
    </div>
</x-public-page>
