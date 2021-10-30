<x-public-page :dontIndex="false">
    <div class="my-20 px-6 max-w-3xl mx-auto text-center">
        <h1 class="type-h2 text-navy mb-12">English Teaching Jobs</h1>
        <p class="max-w-xl mx-auto type-b1">Feel free to browse through the latest jobs here. Remeber, if you are a member, we find the jobs for you, and send it straight to your inbox. No need to be trawling posts like it's the dark ages.</p>
    </div>

    @if($posts->count() === 0)
        <p class="type-b1 text-gray-600 max-w-2xl text-center mx-auto mt-12">Hi there. We haven't started posting any jobs yet, but be sure to check again in the future.</p>
    @endif

    <div class="pb-20 px-6">
        @foreach($posts as $post)
            @include('front.job-posts.index-card', ['post' => $post])
        @endforeach
    </div>
</x-public-page>
