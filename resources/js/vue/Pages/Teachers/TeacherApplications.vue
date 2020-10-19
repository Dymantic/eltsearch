<template>
    <div>
        <page-header title="Your Applications"></page-header>

        <div>
            <div
                v-for="application in applications"
                :key="application.id"
                class="my-8 shadow-lg p-8 rounded-lg max-w-3xl"
            >
                <div
                    v-if="application.show_of_interest"
                    class="inline-flex items-center mb-6 px-4 py-1 bg-green-100 border border-green-700 rounded-lg"
                >
                    <like-icon class="text-green-600 h-5"></like-icon>
                    <p class="mx-4">The school wants you!</p>
                    <router-link
                        :to="`/applications/${application.id}/show-of-interest`"
                        class="text-btn mx-4"
                        >See details</router-link
                    >
                </div>
                <p class="type-h4">
                    {{ application.post.position }} at
                    {{ application.post.school_name }}
                </p>
                <p class="text-gray-600">
                    <span>Applied on {{ application.application_date }} </span>
                    <span> ({{ application.application_date_ago }})</span>
                </p>
                <p class="mt-2">
                    <span class="type-b2">Location: </span>
                    <span class="type-b1">{{ application.post.area }}</span>
                </p>
                <p class="mt-2">
                    <span class="type-b2">Salary: </span>
                    <span class="type-b1">{{ application.post.salary }}</span>
                </p>
                <p class="mt-2">
                    <span class="type-b2">Students: </span>
                    <span class="type-b1">{{
                        application.post.student_ages.join(", ")
                    }}</span>
                </p>
                <div class="mt-4 flex justify-end">
                    <router-link
                        :to="`/applications/${application.id}/details`"
                        class="text-btn mr-4"
                        >Your application</router-link
                    >
                    <router-link
                        :to="`/applications/${application.id}/post`"
                        class="text-btn"
                        >View Post</router-link
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
import LikeIcon from "../../Components/Icons/LikeIcon";
import { showError } from "../../../libs/notifications";
export default {
    components: {
        PageHeader,
        LikeIcon,
    },

    computed: {
        applications() {
            return this.$store.state.applications.all;
        },
    },

    created() {
        this.$store
            .dispatch("applications/fetchApplications")
            .catch(() => showError("Failed to fetch applications"));
    },
};
</script>
