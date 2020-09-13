<template>
    <div v-if="post">
        <page-header title="Job Post">
            <router-link
                :to="`/job-posts/${$route.params.post}/publish`"
                class="btn btn-primary mr-4"
                >Publish</router-link
            >
            <router-link
                :to="`/job-posts/${$route.params.post}/edit`"
                class="btn btn-primary"
                >Edit</router-link
            >
        </page-header>
        <div>
            <div
                class="border border-navy rounded-lg max-w-3xl mx-auto my-20 p-6"
            >
                <div class="flex justify-between">
                    <div class="flex-1 mr-10">
                        <div class="border-b border-navy pb-2">
                            <p class="text-2xl font-bold">
                                {{ post.school_name }}
                            </p>
                            <p>
                                <span class="text-sm pr-3 border-r border-navy"
                                    >Full Time</span
                                >
                                <span class="text-sm px-3 border-r border-navy"
                                    >Tianmu, Taipei</span
                                >
                                <span class="text-sm pl-3">August 2020</span>
                            </p>
                        </div>
                        <div class="py-2">
                            <p class="my-2">
                                <span class="font-bold">Salary: </span>
                                <span>NT$500 - NT$600/hour</span>
                            </p>
                            <p class="my-2">
                                <span class="font-bold">Contract: </span>
                                <span>1 Year</span>
                            </p>
                            <p class="my-2">
                                <span class="font-bold">Hours: </span>
                                <span>25/week approx.</span>
                            </p>
                            <p class="my-2">
                                <span class="font-bold">Times: </span>
                                <span>Afternoon | Evening</span>
                            </p>
                            <p class="my-2">
                                <span class="font-bold">Weekends: </span>
                                <span>No</span>
                            </p>
                        </div>
                    </div>
                    <div>
                        <div class="w-32 h-32">
                            <img
                                src="https://shaneschools.com/en/wp-content/uploads/2020/03/ses_logo-no-text-108.png"
                                alt=""
                                class="w-full h-full object-contain"
                            />
                        </div>
                        <div class="text-center my-4">
                            <a
                                href=""
                                class="bg-sky-blue hover:bg-navy text-white px-4 py-2 shadow rounded-l-full rounded-r-full text-sm"
                                >Apply Now</a
                            >
                        </div>
                    </div>
                </div>
                <div class="pt-10">
                    <p class="font-bold">Job Description</p>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing
                        elit. Accusamus, animi cum eius error, impedit itaque,
                        numquam odit placeat praesentium quaerat quas qui quidem
                        quis quod reiciendis saepe soluta voluptates voluptatum?
                    </p>
                </div>

                <div class="pt-10">
                    <p class="font-bold">Student Ages</p>
                    <ul class="list-disc list-inside">
                        <li>Elementary School</li>
                        <li>Junior High School</li>
                        <li>Senior High School</li>
                    </ul>
                </div>

                <div class="pt-10">
                    <p class="font-bold">Job Benefits</p>
                    <ul class="list-disc list-inside">
                        <li>ARC</li>
                        <li>Health Insurance</li>
                        <li>Back-rubs</li>
                    </ul>
                </div>

                <div class="pt-10">
                    <p class="font-bold">Requirements</p>
                    <ul class="list-disc list-inside">
                        <li>Graduate Degree</li>
                        <li>Police Clearance</li>
                        <li>Health Check</li>
                    </ul>
                </div>

                <div class="text-center my-12">
                    <a
                        href=""
                        class="hover:bg-sky-blue bg-navy text-white px-4 py-2 shadow rounded-l-full rounded-r-full text-sm"
                        >Apply Now</a
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
import { showError } from "../../../libs/notifications";
export default {
    components: {
        PageHeader,
    },

    computed: {
        post() {
            return this.$store.getters["posts/postById"](
                this.$route.params.post
            );
        },
    },

    mounted() {
        this.fetchPosts();
    },

    methods: {
        fetchPosts() {
            this.$store.dispatch("posts/refreshPosts", this.schoolId);
        },
    },
};
</script>
