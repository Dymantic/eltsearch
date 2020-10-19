<template>
    <div v-if="options">
        <page-header :title="trns('create_post.title')"></page-header>
        <job-post-form :options="options" :school-id="schoolId"></job-post-form>
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
