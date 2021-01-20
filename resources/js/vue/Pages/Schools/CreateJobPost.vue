<template>
    <div v-if="options">
        <page-header :title="trns('create_post.title')"></page-header>
        <div
            class="my-12 max-w-xl p-6 rounded-lg border border-sky-blue bg-blue-100"
        >
            <p>{{ trns("job_post_form.use_english") }}</p>
        </div>
        <job-post-form
            :options="options"
            :school-id="schoolId"
            :school-name="schoolName"
        ></job-post-form>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
import JobPostForm from "../../Components/Schools/JobPostForm";

export default {
    components: {
        PageHeader,
        JobPostForm,
    },

    computed: {
        options() {
            return this.$store.state.posts.options;
        },

        schoolId() {
            const school = this.$store.state.schoolprofile.current_school;
            return school ? school.id : null;
        },

        schoolName() {
            const school = this.$store.state.schoolprofile.current_school;
            return school ? school.name : "";
        },
    },

    created() {
        this.$store
            .dispatch("posts/fetchOptions")
            .catch(() => showError(this.trns("errors.fetch_options")));

        this.$store
            .dispatch("locations/fetchLocations")
            .catch(() => showError(this.trns("errors.fetch_locations")));

        this.$store
            .dispatch("schoolprofile/fetchProfiles")
            .catch(() => showError(this.trns("errors.fetch_school_info")));
    },
};
</script>
