<template>
    <div>
        <p class="type-h2 mb-12">Hi {{ name }}</p>

        <profile-disabled v-if="is_disabled" class="my-8"></profile-disabled>

        <essential-actions
            :profile-incomplete="hasStatus('incomplete_profile')"
        ></essential-actions>

        <suggested-actions
            :has-experience="!hasStatus('no_experience')"
            :has-location="!hasStatus('no_location')"
        ></suggested-actions>

        <job-assistance-actions
            :has-job-search="!hasStatus('no_job_search')"
            :has-matches="hasStatus('recent_job_matches')"
        ></job-assistance-actions>
    </div>
</template>

<script type="text/babel">
import EssentialActions from "../../Components/Teachers/Dashboard/EssentialActions";
import SuggestedActions from "../../Components/Teachers/Dashboard/SuggestedActions";
import JobAssistanceActions from "../../Components/Teachers/Dashboard/JobAssistanceActions";
import ProfileDisabled from "../../Components/Teachers/ProfileDisabled";
export default {
    components: {
        ProfileDisabled,
        JobAssistanceActions,
        SuggestedActions,
        EssentialActions,
    },
    computed: {
        profileStatuses() {
            return this.$store.state.profile.dashboard_tiles || [];
        },

        name() {
            return this.$store.state.profile.name;
        },

        is_disabled() {
            return this.$store.getters["profile/profile_disabled"];
        },
    },

    mounted() {
        this.$store.dispatch("profile/fetchGeneralInfo");
    },

    methods: {
        hasStatus(status) {
            return this.profileStatuses.includes(status);
        },
    },
};
</script>
