<x-public-page>
    <div class="py-3 bg-sky-blue text-white flex justify-center items-center">
        <p class=" px-3 text-center type-h4">{{ $announcement }}</p>
    </div>
    @include('front.home.banner')
    <div class="py-20 px-6">
        @foreach($posts as $post)
            @include('front.job-posts.index-card', ['post' => $post])
        @endforeach
    </div>
    <div class="text-center my-12">
        <a href="/job-posts"
           class="btn-text">See more job posts &gt;</a>
    </div>
</x-public-page>
