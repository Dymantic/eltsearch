<x-public-page>
    <div class="my-20 px-6 max-w-3xl mx-auto text-center">
        <h1 class="type-h2 text-navy mb-12">{{ trans('how_it_works.banner.heading') }}</h1>
        <p class="max-w-xl mx-auto type-b1">{{ trans('how_it_works.banner.intro') }}</p>
    </div>

    <div class="px-6 max-w-3xl mx-auto">
        <p class="type-h6 text-navy mb-8">{{ trans('how_it_works.steps_header') }}</p>
            <x-numbered-card index="1">
                <p class="type-b2 text-navy">{{ trans('how_it_works.step_one.heading') }}</p>
                <p class="type-b1">{{ trans('how_it_works.step_one.text') }}</p>
            </x-numbered-card>

        <x-numbered-card index="2">
            <p class="type-b2 text-navy">{{ trans('how_it_works.step_two.heading') }}</p>
            <p class="type-b1">{{ trans('how_it_works.step_two.text') }}</p>
        </x-numbered-card>

        <x-numbered-card index="3">
            <p class="type-b2 text-navy">{{ trans('how_it_works.step_three.heading') }}</p>
            <p class="type-b1">{{ trans('how_it_works.step_three.text') }}</p>
        </x-numbered-card>

        <x-numbered-card index="4">
            <p class="type-b2 text-navy">{{ trans('how_it_works.step_four.heading') }}</p>
            <p class="type-b1">{{ trans('how_it_works.step_four.text') }}</p>
        </x-numbered-card>
    </div>

    <div class="max-w-3xl mx-auto my-20 px-6">
        <p class="type-h6 text-navy mb-8">{{ trans('how_it_works.benefits.heading') }}</p>

        <div class="p-6 shadow-lg max-w-xl mx-auto">
            <x-checked-sentence text="{{ trans('how_it_works.benefits.one') }}"></x-checked-sentence>
            <x-checked-sentence text="{{ trans('how_it_works.benefits.two') }}"></x-checked-sentence>
            <x-checked-sentence text="{{ trans('how_it_works.benefits.three') }}"></x-checked-sentence>
            <x-checked-sentence text="{{ trans('how_it_works.benefits.four') }}"></x-checked-sentence>
            <x-checked-sentence text="{{ trans('how_it_works.benefits.five') }}"></x-checked-sentence>
        </div>
    </div>

    <p class="my-16 max-w-lg mx-auto type-b1 text-center px-6">{{ trans('how_it_works.outro.blurb') }}</p>

    <p class="my-16 max-w-xl mx-auto type-h4 text-navy text-center px-6">{{ trans('how_it_works.outro.sign_up_prompt') }}</p>

    <div class="text-center mb-20 px-6">
        <a href="" class="btn-main type-a1">{{ trans('how_it_works.outro.button') }}</a>
    </div>

</x-public-page>
