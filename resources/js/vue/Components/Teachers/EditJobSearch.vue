<template>
    <div v-if="ready && search">
        <job-search-form
            :search="search"
            @updated="$router.push('/job-search/show')"
        ></job-search-form>
    </div>
</template>

<script type="text/babel">
import JobSearchForm from "./JobSearchForm";
import { showError, showSuccess } from "../../../libs/notifications";
export default {
    components: {
        JobSearchForm,
    },

    data() {
        return {
            ready: false,
        };
    },

    computed: {
        search() {
            return this.$store.state.placements.job_search;
        },
    },

    mounted() {
        this.$store
            .dispatch("placements/fetchJobSearch")
            .catch(() => showError("Failed to fetch current job search."));
        Promise.all([
            this.$store.dispatch("placements/fetchOptions"),
            this.$store.dispatch("locations/fetchLocations"),
        ])
            .then(() => (this.ready = true))
            .catch(() => showError("Failed to fetch available options"));
    },
};
</script>
