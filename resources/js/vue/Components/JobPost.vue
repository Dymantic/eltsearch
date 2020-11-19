<template>
    <div>
        <div class="border border-navy rounded-lg max-w-3xl mx-auto my-20 p-6">
            <div class="flex justify-between">
                <div class="flex-1 mr-10">
                    <div class="border-b border-navy pb-2">
                        <p class="text-2xl font-bold">
                            {{ post.school_name }}
                        </p>
                        <p>
                            <span class="text-sm pr-3 border-r border-navy">{{
                                post.position
                            }}</span>
                            <span class="text-sm px-3 border-r border-navy">{{
                                post.engagement
                            }}</span>
                            <span class="text-sm px-3">{{ post.area }}</span>
                        </p>
                    </div>
                    <div class="py-2">
                        <p class="my-2">
                            <span class="font-bold"
                                >{{
                                    trns(
                                        "job_post.start_date",
                                        "Starting Date"
                                    )
                                }}:
                            </span>
                            <span>{{ post.start_date }}</span>
                        </p>
                        <p class="my-2">
                            <span class="font-bold"
                                >{{ trns("job_post.salary", "Salary") }}:
                            </span>
                            <span>{{ post.salary }}</span>
                        </p>
                        <p class="my-2">
                            <span class="font-bold"
                                >{{ trns("job_post.contract", "Contract") }}:
                            </span>
                            <span>{{ post.contract }}</span>
                        </p>
                        <p class="my-2">
                            <span class="font-bold"
                                >{{ trns("job_post.hours", "Hours") }}:
                            </span>
                            <span>{{ post.hours_per_week }}/week approx.</span>
                        </p>
                        <p class="my-2">
                            <span class="font-bold"
                                >{{ trns("job_post.times", "Times") }}:
                            </span>
                            <span>{{ post.schedule.join(", ") }}</span>
                        </p>
                        <p class="my-2">
                            <span class="font-bold"
                                >{{ trns("job_post.weekends", "Weekends") }}:
                            </span>
                            <span>{{ post.work_on_weekends }}</span>
                        </p>
                    </div>
                </div>
                <div>
                    <div class="w-32 h-32">
                        <img
                            :src="post.logo.thumb"
                            alt=""
                            class="w-full h-full object-contain"
                        />
                    </div>
                    <div class="text-center my-4">
                        <router-link
                            v-if="applyUrl"
                            :to="applyUrl"
                            class="btn btn-primary"
                            >Apply</router-link
                        >
                        <span
                            v-else
                            class="bg-sky-blue hover:bg-navy text-white px-4 py-2 shadow rounded-l-full rounded-r-full text-sm"
                            >Apply Now</span
                        >
                    </div>
                </div>
            </div>
            <div class="pt-10">
                <p class="font-bold">
                    {{ trns("job_post.description", "Job Description") }}
                </p>
                <p>
                    {{ post.description }}
                </p>
            </div>

            <div class="pt-10">
                <p class="font-bold">
                    {{ trns("job_post.students", "Student Ages") }}
                </p>
                <ul class="list-disc list-inside">
                    <li v-for="age in post.student_ages">
                        {{ age }}
                    </li>
                </ul>
            </div>

            <div class="pt-10">
                <p class="font-bold">
                    {{ trns("job_post.benefits", "Job Benefits") }}
                </p>
                <ul class="list-disc list-inside">
                    <li v-for="benefit in post.benefits">
                        {{ benefit }}
                    </li>
                </ul>
            </div>

            <div class="pt-10">
                <p class="font-bold">
                    {{ trns("job_post.requirements", "Requirements") }}
                </p>
                <ul class="list-disc list-inside">
                    <li v-for="requirement in post.requirements">
                        {{ requirement }}
                    </li>
                </ul>
            </div>

            <div class="text-center my-12">
                <router-link
                    v-if="applyUrl"
                    :to="applyUrl"
                    class="btn btn-primary"
                    >Apply</router-link
                >
                <span
                    v-else
                    class="hover:bg-sky-blue bg-navy text-white px-4 py-2 shadow rounded-l-full rounded-r-full text-sm"
                    >Apply Now</span
                >
            </div>
        </div>
        <div
            class="flex justify-start lg:justify-center w-full overflow-x-auto"
        >
            <div
                class="h-40 w-40 mx-4 flex-shrink-0"
                v-for="image in post.images"
                :key="image.id"
            >
                <img
                    :src="image.thumb"
                    alt=""
                    class="w-full h-full object-cover"
                />
            </div>
        </div>
        <div class="my-8 text-center" v-if="canEdit">
            <router-link
                :to="`/job-posts/${$route.params.post}/images`"
                class="text-btn"
                >{{ trns("actions.edit_images", "Edit images") }}</router-link
            >
        </div>
    </div>
</template>

<script type="text/babel">
export default {
    props: ["post", "can-edit", "apply-url"],
};
</script>
