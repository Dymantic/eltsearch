<x-public-page title="Apply for job">
    <div class="max-w-4xl mx-auto px-6 py-12">
        <div class="pt-20 px-6 max-w-5xl mx-auto">
            <p class="type-h3 text-gray-600 text-center">Job Application for {{ $post['school_name'] }}</p>
            <x-step-header :step="4" :of="4"></x-step-header>
            <p class="max-w-lg mx-auto my-6">You're almosrt there. It is time to finish off your application to {{ $post['school_name'] }}. You just need to introduce yourself, and let thm know how to contact you.</p>
        </div>




        <form method="POST" action="/guest-applications" class="max-w-lg mx-auto">
            {!! csrf_field() !!}
            <div class="mb-12">
                <label class="type-a1 text-navy" for="cover_letter">Introduction</label>
                <p class="my-6">Briefly introduce yourself and explain why you would be a great {{ $post['position'] }} at {{ $post['school_name'] }}.</p>
                <textarea name="cover_letter" id="cover_letter" class="border border-navy rounded-lg p-2 block w-full h-64"></textarea>
            </div>
            <p class="type-a1 text-navy">Contact details</p>
            <p class="my-6 type-b1">Leave an email address or phone number for the school to use, should they wish to contact you. You can leave a different email that the one you use to sign-up if you wish.</p>
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
