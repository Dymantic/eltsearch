<x-public-page :alpine="true">
    <div class="pt-20 px-6 max-w-5xl mx-auto">
        <p class="type-h3 text-gray-600 text-center">Job Application for {{ $post['school_name'] }}</p>
        <x-step-header :step="2" :of="4"></x-step-header>
        <p class="max-w-lg mx-auto my-6">Add some of your previous work experience to let {{ $post['school_name'] }} know how capable you are. If this is your first teaching job, it is fine to put any previous work experience you may have.</p>
    </div>

    <div class="my-12 max-w-lg mx-auto px-6" x-data="experienceForm()">
        <form action="/guest-applications/experience" method="POST">
            {!! csrf_field() !!}

            @if($errors->any())
                <div class="border border-red-600 p-6 rounded-lg my-6">
                    <p class="type-b2 text-red text-center text-red-500">Some of your input is invalid. Please correct it before you proceed.</p>
                </div>
            @endif
            <template x-for="(job, index) in experience" :key="index">
                <div class="max-w-lg mx-auto my-6 border-b border-sky-blue pb-6">
                    <div class="mb-6 border-b border-gray-300 flex justify-between items-center">
                        <p class="type-a1 text-navy capitalize" x-text="`Employer ${getNumber(index)}`"></p>
                        <button x-show="index > 0" type="button" @click="removeEmployer(index)" class="text-gray-600 hover:text-navy type-b4">Remove</button>
                    </div>
                    <div class="my-6">
                        <label class="form-label" for="">Employer</label>
                        <span class="text-sm text-red-500" x-show="hasError('employer', index)">Invalid input. Please check.</span>
                        <input class="form-text-input" type="text" x-model="job.employer" :name="`experience[${index}][employer]`">
                    </div>
                    <div class="my-6">
                        <label class="form-label" for="">Job Title</label>
                        <span class="text-sm text-red-500" x-show="hasError('job_title', index)">Invalid input. Please check.</span>
                        <input class="form-text-input" type="text" x-model="job.title" :name="`experience[${index}][job_title]`">
                    </div>
                    <div class="my-6">
                        <p class="form-label mb-4">When did you start working this job?</p>
                        <span class="text-sm text-red-500" x-show="hasError('start_month', index)">Invalid input. Please check.</span>
                        <span class="text-sm text-red-500" x-show="hasError('start_year', index) && !hasError('start_month', index)">Invalid input. Please check.</span>
                        <div class="flex">
                            <div class="mr-6">
                                <label class="form-label" for="">Month</label>
                                <select class="form-text-input" :name="`experience[${index}][start_month]`" x-model="job.start_month">
                                    <option value="1">Jan</option>
                                    <option value="2">Feb</option>
                                    <option value="3">Mar</option>
                                    <option value="4">Apr</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">Aug</option>
                                    <option value="9">Sep</option>
                                    <option value="10">Oct</option>
                                    <option value="11">Nov</option>
                                    <option value="12">Dec</option>
                                </select>
                            </div>

                            <div class="">
                                <label class="form-label" for="">Year</label>
                                <select class="form-text-input" :name="`experience[${index}][start_year]`" x-model="job.start_year">
                                    @foreach(range(0,30) as $diff)
                                        <option value="{{ now()->year - $diff }}">{{ now()->year - $diff }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="my-6">
                        <p class="form-label">When did you end this job?</p>
                        <p class="text-gray-600 my-2 type-b3">You may leave this blank if you are still currently employed here.</p>
                        <span class="text-sm text-red-500" x-show="hasError('end_month', index)">Invalid input. Please check.</span>
                        <span class="text-sm text-red-500" x-show="hasError('end_year', index) && !hasError('end_month', index)">Invalid input. Please check.</span>
                        <div class="flex">
                            <div class="mr-6">
                                <label class="form-label" for="">Month</label>
                                <select class="form-text-input" :name="`experience[${index}][end_month]`" x-model="job.end_month">
                                    <option value=""></option>
                                    <option value="1">Jan</option>
                                    <option value="2">Feb</option>
                                    <option value="3">Mar</option>
                                    <option value="4">Apr</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">Aug</option>
                                    <option value="9">Sep</option>
                                    <option value="10">Oct</option>
                                    <option value="11">Nov</option>
                                    <option value="12">Dec</option>
                                </select>
                            </div>

                            <div class="">
                                <label class="form-label" for="">Year</label>
                                <span class="text-sm text-red-500" x-show="hasError('description', index)">Invalid input. Please check.</span>
                                <span class="text-sm text-red-500" x-show="hasError('start_year', index)">Invalid input. Please check.</span>
                                <select class="form-text-input" :name="`experience[${index}][end_year]`" x-model="job.end_year">
                                    <option value=""></option>
                                    @foreach(range(0,30) as $diff)
                                        <option value="{{ now()->year - $diff }}">{{ now()->year - $diff }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                    </div>



                    <div class="my-6">
                        <label class="form-label" for="">Job Description</label>
                        <textarea class="form-text-input h-32" :name="`experience[${index}][description]`" x-model="job.description"></textarea>
                    </div>
                </div>

            </template>

            <div class="my-6">
                <button @click="addEmployer()" type="button" class="flex leading-none items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current h-5 text-gray-600">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span>Add Another employer</span>
                </button>
            </div>
            <div class="mt-12 flex flex-col items-center">
                <button class="btn-main mb-6">Next Step &rarr;</button>
                <a class="text-gray-600 hover:text-navy" href="/guest-applications/add-profile-image">Skip this step</a>
            </div>
        </form>
    </div>

    <script>
        function experienceForm() {
            return {
                @if($errors->any())
                experience: [
                    @foreach(old('experience') as $job)
                    {
                    employer: '{{ $job['employer'] }}',
                    title: '{{ $job['job_title'] }}',
                    start_month: {{ $job['start_month'] }},
                    start_year: '{{ $job['start_year'] }}',
                    end_month: '{{ $job['end_month'] }}',
                    end_year: '{{ $job['end_year'] }}',
                    description: '{{ $job['description'] }}'
                },
                @endforeach
                ],
                errors: [
                    @foreach($errors->getMessages() as $key => $value)
                    '{{ $key }}',
                    @endforeach
                ],
                @else
                    experience: [{
                    employer: '',
                    title: '',
                    start_month: 1,
                    start_year: 2019,
                    end_month: '',
                    end_year: '',
                    description: ''
                }],
                errors: [],
                @endif
                hasError(key, index) {
                    return this.errors.includes(`experience.${index}.${key}`);
                },
                addEmployer() {
                    this.experience.push({
                        employer: '',
                        title: '',
                        start_month: '1',
                        start_year: 2019,
                        end_month: '',
                        end_year: '',
                        description: ''
                    });
                },
                removeEmployer(index) {
                    this.experience = this.experience.filter((emp, ind) => ind !== index);
                },
                getNumber(index) {
                    const words = ['One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];
                    return words[index];
                }
            };
        }
    </script>

</x-public-page>
