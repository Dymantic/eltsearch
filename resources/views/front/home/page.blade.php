<x-public-page>
    <div class="py-3 text-white flex justify-center items-center announcement-bar @if($announcement_is_urgent) bg-orange @else bg-sky-blue @endif">
        <div class=" px-3 text-center type-h4">{!! $announcement !!}</div>
    </div>
    @include('front.home.banner')
    <div class="py-20 px-6">
        <p class="type-h2 text-center text-navy">Latest Job Posts</p>
        @foreach($posts as $post)
            @include('front.job-posts.index-card', ['post' => $post])
        @endforeach
    </div>
    <div class="text-center my-12">
        <a href="/job-posts"
           class="btn-text">See more job posts &gt;</a>
    </div>
</x-public-page>
