<x-public-page title="Apply for job">
    <div class="max-w-4xl mx-auto px-6 py-12">
        <h1 class="type-h3">Apply for job at {{ $post['school_name'] }}</h1>

        <p class="my-6">Write a cover letter to be sent along with your resume to {{ $post['school_name'] }}</p>
        <form method="POST" action="/job-posts/{{ $post['slug'] }}/apply" class="max-w-lg">
            {!! csrf_field() !!}
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
