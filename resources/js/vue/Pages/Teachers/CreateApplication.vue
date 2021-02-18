<template>
    <div v-if="post">
        <page-header title="Apply for job" :back="true"></page-header>

        <application-form :post="post"></application-form>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
import ApplicationForm from "../../Components/Teachers/ApplicationForm";
export default {
    components: {
        ApplicationForm,
        PageHeader,
    },

    computed: {
        match() {
            return this.$store.getters["matches/byId"](
                this.$route.params.job_match
            );
        },

        post() {
            return this.match ? this.match.post : null;
        },
    },

    mounted() {
        this.$store.dispatch("matches/fetch");
    },
};
</script>
