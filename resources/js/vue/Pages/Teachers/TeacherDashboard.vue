<template>
    <div>
        <p class="type-h2 mb-12">Hi {{ name }}</p>
        <incomplete-profile
            class="my-8"
            v-if="hasStatus('incomplete_profile')"
        ></incomplete-profile>

        <no-job-search
            class="my-8"
            v-if="hasStatus('no_job_search')"
        ></no-job-search>

        <no-experience
            class="my-8"
            v-if="hasStatus('no_experience')"
        ></no-experience>
    </div>
</template>

<script type="text/babel">
import NoJobSearch from "../../Components/Teachers/Dashboard/NoJobSearch";
import NoExperience from "../../Components/Teachers/Dashboard/NoExperience";
import IncompleteProfile from "../../Components/Teachers/Dashboard/IncompleteProfile";
export default {
    components: { IncompleteProfile, NoExperience, NoJobSearch },
    computed: {
        profileStatuses() {
            return this.$store.state.profile.dashboard_tiles || [];
        },

        name() {
            return this.$store.state.profile.name;
        },
    },

    methods: {
        hasStatus(status) {
            return this.profileStatuses.includes(status);
        },
    },
};
</script>
