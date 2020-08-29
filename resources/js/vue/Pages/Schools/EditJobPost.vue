<template>
    <div v-if="post">
        <page-header title="Edit Job Post"></page-header>

        <job-post-form
            :options="options"
            :school-id="schoolId"
            :post="post"
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
        post() {
            return this.$store.getters["posts/postById"](
                this.$route.params.post
            );
        },

        options() {
            return this.$store.state.posts.options;
        },

        schoolId() {
            const school = this.$store.state.schoolprofile.current_school;
            return school ? school.id : null;
        },
    },

    watch: {
        schoolId(to) {
            if (to) {
                this.fetchPosts();
            }
        },
    },

    created() {
        this.$store
            .dispatch("posts/fetchOptions")
            .catch(() => showError("Failed to fetch options."));

        this.$store
            .dispatch("locations/fetchLocations")
            .catch(() => showError("Failed to fetch locations."));

        this.$store
            .dispatch("schoolprofile/fetchProfiles")
            .catch(() => showError("Failed to fetch school info."));
    },

    mounted() {
        if (this.schoolId) {
            this.fetchPosts();
        }
    },

    methods: {
        fetchPosts() {
            this.$store.dispatch("posts/refreshPosts", this.schoolId);
        },
    },
};
</script>
