<x-public-page :dontIndex="true">
    <div class="md:border border-navy rounded-lg max-w-3xl mx-auto my-12 md:my-20 p-6">
        <div class="w-32 h-32 mx-auto mb-12 block md:hidden">
            <img src="{{ $post['logo']['thumb'] }}" alt="" class="w-full h-full object-contain">
        </div>
        <div class="flex justify-between">
            <div class="flex-1 mr-10">
                <div class="border-b border-navy pb-2">
                    <p class="text-2xl font-bold text-navy">{{ $post['school_name'] }}</p>
                    <p class="flex flex-col md:flex-row md:divide-x divide-navy md:gap-3">
                        <span class="text-sm">{{ $post['engagement'] }}</span>
                        <span class="text-sm md:pl-3">{{ $post['area'] }}</span>
                        <span class="text-sm md:pl-3">{{ $post['start_date'] }}</span>
                    </p>
                </div>
                <div class="py-2">
                    <p class="my-2">
                        <span class="font-bold text-navy">Job: </span>
                        <span>{{ $post['position'] }}</span>
                    </p>
                    <p class="my-2">
                        <span class="font-bold text-navy">Salary: </span>
                        <span>{{ $post['salary'] }}</span>
                    </p>
                    <p class="my-2">
                        <span class="font-bold text-navy">Contract: </span>
                        <span>{{ $post['contract'] }}</span>
                    </p>
                    <p class="my-2">
                        <span class="font-bold text-navy">Hours: </span>
                        <span>{{ $post['hours_per_week'] }}/week approx.</span>
                    </p>
                    <p class="my-2">
                        <span class="font-bold text-navy">Times: </span>
                        <span class="divide-x divide-navy">
                        @foreach($post['schedule'] as $time)
                        <span class="px-2">{{ $time }}</span>
                        @endforeach
                        </span>
                    </p>
                    <p class="my-2">
                        <span class="font-bold text-navy">Weekends: </span>
                        <span>{{ $post['work_on_weekends'] }}</span>
                    </p>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="w-32 h-32">
                    <img src="{{ $post['logo']['thumb'] }}" alt="" class="w-full h-full object-contain">
                </div>
                @if($can_apply)
                <div class="text-center my-4">
                    <a href="/job-posts/{{ $post['slug'] }}/apply" class="bg-sky-blue hover:bg-navy text-white px-4 py-2 shadow rounded-l-full rounded-r-full text-sm">Apply Now</a>
                </div>
                @endif
            </div>
        </div>
        <div class="pt-10">
            <p class="font-bold text-navy">Job Description</p>
            <p>{{ $post['description'] }}</p>
        </div>

        <div class="pt-10">
            <p class="font-bold text-navy">Student Ages</p>
            <ul class="list-disc list-inside">
                @foreach($post['student_ages'] as $age)
                <li>{{ $age }}</li>
                @endforeach
            </ul>
        </div>

        <div class="pt-10">
            <p class="font-bold text-navy">Job Benefits</p>
            <ul class="list-disc list-inside">
                @foreach($post['benefits'] as $benefit)
                    <li>{{ $benefit }}</li>
                @endforeach
            </ul>
        </div>

        <div class="pt-10">
            <p class="font-bold text-navy">Requirements</p>
            <ul class="list-disc list-inside">
                @foreach($post['requirements'] as $requirement)
                    <li>{{ $requirement }}</li>
                @endforeach
            </ul>
        </div>

        @if($can_apply)
            <div class="text-center my-12">
                <a href="/job-posts/{{ $post['slug'] }}/apply" class="btn-main">Apply Now</a>
            </div>
        @elseif($has_application)
            <div class="text-center my-12">
                <p>You have already applied for this job! Visit your <a href="/teachers#/applications" class="text-sky-blue underline hover:text-navy">dashboard</a> to see details.</p>
            </div>
        @elseif($profile_incomplete)
            <div class="text-center my-12">
                <p>You need to complete your profile before you can apply for this job! Visit your <a href="/teachers#/applications" class="text-sky-blue underline hover:text-navy">dashboard</a> to get that done.</p>
            </div>
        @endif

    </div>

    <div class="my-12 flex justify-center max-w-5xl mx-auto" x-data="schoolImages()">
        @foreach($post['images'] as $image)
        <div class="w-1/4 mx-4">
            <img src="{{ $image['thumb'] }}" alt="{{ $post['school_name'] }}" class="w-full h-full object-cover" @click="showImage('{{ $image['full'] }}')">
        </div>
        @endforeach
        <div class="fixed inset-0 bg-black bg-opacity-75 w-full h-full flex justify-center items-center" x-show="show" @keydown.escape.window="show = false">
            <button x-cloak type="button" class="m-6 bg-white shadow-lg rounded-l-full rounded-r-full px-6 py-2 absolute top-16 right-0 hover:bg-baby-blue focus:outline-none" @click="show = false">X</button>
            <div class="max-w-4xl max-h-full">
                <img :src="source"
                     alt="" class="w-full h-full object-contain">
            </div>

        </div>

    </div>
    <div class="flex justify-center my-12">
        <a class="type-a1 text-navy hover:text-sky-blue underline" href="{{ $post['school_slug'] }}">Visit School Profile</a>
    </div>
    <script>
        function schoolImages() {
            return {
                show: false,
                source: '{{ $post['images'][0]['full'] ?? "" }}',
                showImage(s) {
                    this.source = s;
                    this.show = true;
                }
            };
        }
    </script>
</x-public-page>
