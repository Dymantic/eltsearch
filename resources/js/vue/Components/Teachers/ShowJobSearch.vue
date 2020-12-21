<template>
    <div>
        <page-header title="Your job search">
            <router-link class="btn btn-primary" to="/job-search/edit">{{
                empty ? "Create Your Search" : "Edit"
            }}</router-link>
        </page-header>

        <p class="mb-10 text-gray-600 max-w-lg">
            You will be notified of jobs that match your search for the
            following criteria. It is worth noting that the more specific you
            make your search, the fewer matches you will get.
        </p>

        <div>
            <div v-for="criteria in used_criteria" class="my-6">
                <p class="type-h4 capitalize text-navy mb-2">
                    {{ criteria.criteria }}
                </p>
                <ul
                    class="pl-4 type-b1"
                    v-if="criteria.description_type === 'list'"
                >
                    <li v-for="item in criteria.description">{{ item }}</li>
                </ul>
                <p
                    v-if="criteria.description_type === 'string'"
                    class="pl-4 type-b1"
                >
                    {{ criteria.description }}
                </p>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../PageHeader";
import { showError } from "../../../libs/notifications";

export default {
    components: {
        PageHeader,
    },

    computed: {
        search() {
            return this.$store.state.placements.job_search;
        },

        used_criteria() {
            const criteria = this.search ? this.search.search_descriptions : [];
            return criteria.filter((crit) => crit.included);
        },

        empty() {
            return this.used_criteria.length === 0;
        },
    },

    created() {
        return this.$store
            .dispatch("placements/fetchJobSearch")
            .catch(() => showError("Unable to fetch job search."));
    },
};
</script>
