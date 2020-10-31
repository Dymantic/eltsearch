<x-public-page>
    <div class="border border-navy rounded-lg max-w-3xl mx-auto my-20 p-6">
        <div class="flex justify-between">
            <div class="flex-1 mr-10">
                <div class="border-b border-navy pb-2">
                    <p class="text-2xl font-bold">{{ $post['school_name'] }}</p>
                    <p>
                        <span class="text-sm pr-3 border-r border-navy">{{ $post['engagement'] }}</span>
                        <span class="text-sm px-3 border-r border-navy">{{ $post['area'] }}</span>
                        <span class="text-sm pl-3">{{ $post['start_date'] }}</span>
                    </p>
                </div>
                <div class="py-2">
                    <p class="my-2">
                        <span class="font-bold">Salary: </span>
                        <span>{{ $post['salary'] }}</span>
                    </p>
                    <p class="my-2">
                        <span class="font-bold">Contract: </span>
                        <span>{{ $post['contract'] }}</span>
                    </p>
                    <p class="my-2">
                        <span class="font-bold">Hours: </span>
                        <span>{{ $post['hours_per_week'] }}/week approx.</span>
                    </p>
                    <p class="my-2">
                        <span class="font-bold">Times: </span>
                        <span class=" divide-x divide-navy">
                        @foreach($post['schedule'] as $time)
                        <span class="px-2">{{ $time }}</span>
                        @endforeach
                        </span>
                    </p>
                    <p class="my-2">
                        <span class="font-bold">Weekends: </span>
                        <span>{{ $post['work_on_weekends'] }}</span>
                    </p>
                </div>
            </div>
            <div>
                <div class="w-32 h-32">
                    <img src="https://shaneschools.com/en/wp-content/uploads/2020/03/ses_logo-no-text-108.png" alt="" class="w-full h-full object-contain">
                </div>
                @if(!$has_application)
                <div class="text-center my-4">
                    <a href="/job-posts/{{ $post['slug'] }}/apply" class="bg-sky-blue hover:bg-navy text-white px-4 py-2 shadow rounded-l-full rounded-r-full text-sm">Apply Now</a>
                </div>
                @endif
            </div>
        </div>
        <div class="pt-10">
            <p class="font-bold">Job Description</p>
            <p>{{ $post['description'] }}</p>
        </div>

        <div class="pt-10">
            <p class="font-bold">Student Ages</p>
            <ul class="list-disc list-inside">
                @foreach($post['student_ages'] as $age)
                <li>{{ $age }}</li>
                @endforeach
            </ul>
        </div>

        <div class="pt-10">
            <p class="font-bold">Job Benefits</p>
            <ul class="list-disc list-inside">
                @foreach($post['benefits'] as $benefit)
                    <li>{{ $benefit }}</li>
                @endforeach
            </ul>
        </div>

        <div class="pt-10">
            <p class="font-bold">Requirements</p>
            <ul class="list-disc list-inside">
                @foreach($post['requirements'] as $requirement)
                    <li>{{ $requirement }}</li>
                @endforeach
            </ul>
        </div>

        @if(!$has_application)
            <div class="text-center my-12">
                <a href="/job-posts/{{ $post['slug'] }}/apply" class="hover:bg-sky-blue bg-navy text-white px-4 py-2 shadow rounded-l-full rounded-r-full text-sm">Apply Now</a>
            </div>
        @else
            <div class="text-center my-12">
                <p>You have already applied for this job! Visit your <a href="/teachers#/applications" class="text-sky-blue underline hover:text-navy">dashboard</a> to see details.</p>
            </div>
        @endif

    </div>

    <div class="my-12 flex justify-center max-w-5xl mx-auto">
        @foreach($post['images'] as $image)
        <div class="w-1/4 mx-4">
            <img src="{{ $image['thumb'] }}" alt="{{ $post['school_name'] }}" class="w-full h-full object-cover">
        </div>
        @endforeach
    </div>
</x-public-page>