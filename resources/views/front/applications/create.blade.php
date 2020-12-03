<x-public-page title="Apply for job">
    <div class="max-w-4xl mx-auto px-6 py-12">
        <h1 class="type-h3">Apply for job at {{ $post['school_name'] }}</h1>

        <p class="my-6 max-w-2xl type-b1">Hi there, nice to meet you. Before we can send your application we need to get to know you a bit more. This is a two-step process, by the end of which you will have been signed up for your
            <span class="type-b2">free  ELT Search account</span>, and your application will be safely in the hands of <span class="type-b2">{{ $post['school_name'] }}</span>. If you are already a member, you can apply
            <a href="/teachers#/apply-to-post/{{ $post['slug'] }}" class="text-sky-blue underline hover:text-navy">here</a>.</p>

        <p class="my-6">Write a cover letter to be sent along with your resume to {{ $post['school_name'] }}</p>
        <form method="POST" action="/guest-applications" class="max-w-lg">
            {!! csrf_field() !!}
            <input type="hidden" name="job_post_slug" value="{{ $post['slug'] }}">
            <div>
                <label class="type-b2 text-navy mb-1" for="cover_letter">Cover letter</label>
                <textarea name="cover_letter" id="cover_letter" class="border border-navy rounded-lg p-2 block w-full h-64"></textarea>
            </div>
            <p class="mt-12 mb-6 type-b1">Leave an email address or phone number for the school to use, should they wish to contact you.</p>
            <div class="my-6">
                <label class="type-b2" for="email">Email</label>
                <input type="email" class="p-2 block border border-navy rounded-lg w-full" id="email">
            </div>
            <div class="my-6">
                <label class="type-b2" for="phone">Phone number</label>
                <input type="text" name="phone" class="p-2 block border border-navy rounded-lg w-full" id="phone">
            </div>

            <div class="my-20">
                <button type="submit" class="btn-main">Submit Application</button>
            </div>
        </form>
    </div>
</x-public-page>
