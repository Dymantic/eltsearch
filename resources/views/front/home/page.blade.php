<x-public-page :dontIndex="false">
    <div class="py-3 text-white flex justify-center items-center announcement-bar @if($announcement_is_urgent) bg-orange @else bg-sky-blue @endif">
        <div class=" px-3 text-center type-h4">{!! $announcement !!}</div>
    </div>
    @include('front.home.banner')
    <div class="py-20 px-6">
        <p class="type-h2 text-center text-navy">Latest Job Posts</p>
        @if($posts->count() === 0)
            <p class="type-b1 text-gray-600 max-w-2xl text-center mx-auto mt-12">Hi there. There currently aren't any jobs posted, but be sure to check again soon.</p>
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
    <div class="flex flex-col items-center px-8 my-6">
        <p class="mb-2 type-b1 text-gray-600">Are you a tutor? Looking to monetize your free time?</p>
        <p class="mb-6 type-b1 text-gray-600">Check out Bookee, proud partner of ELT Search.</p>
        <a target="_blank" rel="nofollow" href="https::/bookee.cc">
            <img src="/images/bookee.png" class="w-48"
                alt="Bookee logo">
        </a>
    </div>
</x-public-page>
