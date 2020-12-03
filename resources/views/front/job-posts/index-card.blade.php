<div class="border border-navy rounded-lg p-6 max-w-2xl my-12 mx-auto shadow-lg">
    <div class="flex justify-between items-start">
        <div class="flex-1 mr-8">
            <p class="type-h3 mb-3 border-b border-navy">
                <a href="/job-posts/{{ $post['slug'] }}" class="text-navy hover:text-sky-blue">{{ $post['school_name'] }}</a>
            </p>
            <p class="mb-1 type-b1"><span class="type-b2">Company: </span>{{ $post['school'] }}</p>
            <p class="mb-1 type-b1"><span class="type-b2">Location: </span>{{ $post['area'] }}</p>
            <p class="mb-1 type-b1"><span class="type-b2">Part Time or Full Time: </span>{{ $post['engagement'] }}</p>
            <p class="mb-1 type-b1"><span class="type-b2">Start Date: </span>{{ $post['start_date'] }}</p>
        </div>
        <div class="h-12 md:h-24 w-12 md:w-24">
            <img src="{{ $post['logo']['thumb'] }}"
                 alt="" class="w-full h-full object-contain">
        </div>
    </div>
    <p class="type-b1">{{ $post['description'] }}</p>
    <div class="flex justify-end mt-2">
        <a href="/job-posts/{{ $post['slug'] }}" class="btn-text">See Job &gt;</a>
    </div>
</div>
