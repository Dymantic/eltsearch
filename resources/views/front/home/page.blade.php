<x-public-page :dontIndex="false">
    <div class="py-3 text-white flex justify-center items-center announcement-bar @if($announcement_is_urgent) bg-orange @else bg-sky-blue @endif">
        <div class=" px-3 text-center type-h4">{!! $announcement !!}</div>
    </div>
    @include('front.home.banner')
    <div class="py-20 px-6">
        <p class="type-h2 text-center text-navy">Latest Job Posts</p>
        @if($posts->count() === 0)
            <p class="type-b1 text-gray-600 max-w-2xl text-center mx-auto mt-12">Hi there. We haven't started posting any jobs yet, but be sure to check again in the future.</p>
        @endif
        @foreach($posts as $post)
            @include('front.job-posts.index-card', ['post' => $post])
        @endforeach
    </div>
    @if($posts->count() > 0)
    <div class="text-center my-12">
        <a href="/job-posts"
           class="btn-text">See more job posts &gt;</a>
    </div>
    @endif
</x-public-page>
