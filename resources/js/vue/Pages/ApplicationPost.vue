<template>
    <div v-if="application">
        <page-header title="Job Post" :back="true"> </page-header>

        <job-post :post="application.post" :can-edit="false"></job-post>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../Components/PageHeader";
import JobPost from "../Components/JobPost";
export default {
    components: {
        PageHeader,
        JobPost,
    },

    computed: {
        application() {
            return this.$store.getters["applications/byId"](
                this.$route.params.application
            );
        },
    },

    created() {
        this.$store.dispatch("applications/fetchApplications");
    },
};
</script>
