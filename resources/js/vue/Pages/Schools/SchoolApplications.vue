<template>
    <div>
        <page-header :title="trns('applications.title')"></page-header>

        <div>
            <div v-for="application in applications" class="my-6 p-3 shadow">
                <p class="mb-2">
                    <span class="type-b2">{{
                        application.application_date
                    }}</span>
                    for
                    <span class="type-b2">{{ application.position }}</span> at
                    <span class="type-b2">{{ application.school_name }}</span>
                </p>
                <div class="flex items-center">
                    <img
                        :src="application.teacher.avatar"
                        class="h-12 w-12 rounded-full"
                        alt=""
                    />
                    <p class="type-h4 px-6">{{ application.teacher.name }}</p>
                    <p class="type-b1 px-6">
                        {{ application.teacher.nationality }}
                    </p>
                </div>
                <div class="mt-4 flex justify-end">
                    <router-link
                        :to="`/applications/${application.id}`"
                        class="text-btn"
                        >{{ trns("applications.view_resume") }}</router-link
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
        applications() {
            return this.$store.state.applications.all;
        },
    },

    created() {
        this.$store
            .dispatch("applications/fetchApplications")
            .catch(() => showError(this.trns("errors.fetch_applications")));
    },
};
</script>
