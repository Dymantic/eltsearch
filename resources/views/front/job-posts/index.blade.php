<x-public-page>
    <div class="my-20 px-6 max-w-3xl mx-auto text-center">
        <h1 class="type-h2 text-navy mb-12">English Teaching Jobs</h1>
        <p class="max-w-xl mx-auto type-b1">Feel free to browse through the latest jobs here. Remeber, if you are a member, we find the jobs for you, and send it straight to your inbox. No need to be trawling posts like it's the dark ages.</p>
    </div>

    <div class="pb-20 px-6">
        @foreach($posts as $post)
            @include('front.job-posts.index-card', ['post' => $post])
        @endforeach
    </div>
</x-public-page>
