<template>
    <div>
        <p class="type-h3 mb-12 text-navy">
            {{ trns("dashboard.greeting", "", { name }) }}
        </p>

        <profile-disabled v-if="is_disabled" class="my-8"></profile-disabled>

        <essential-actions
            :profile-incomplete="hasStatus('incomplete_profile')"
            :has-billing-info="!hasStatus('incomplete_billing')"
        ></essential-actions>

        <suggested-actions
            :has-tokens="!hasStatus('no_tokens')"
            :has-resume-access="!hasStatus('no_resume_pass')"
            :can-add-images="hasStatus('can_add_images')"
            :has-draft-posts="hasStatus('has_draft_posts')"
        ></suggested-actions>

        <find-teacher-actions
            :has-applications="hasStatus('has_recent_applications')"
            :has-unread-messages="hasStatus('has_messages')"
        ></find-teacher-actions>
    </div>
</template>

<script type="text/babel">
import EssentialActions from "../../Components/Schools/Dashboard/EssentialActions";
import SuggestedActions from "../../Components/Schools/Dashboard/SuggestedActions";
import FindTeacherActions from "../../Components/Schools/Dashboard/FindTeacherActions";
import ProfileDisabled from "../../Components/Schools/ProfileDisabled";
export default {
    components: {
        ProfileDisabled,
        FindTeacherActions,
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
            return this.$store.getters["schoolprofile/is_disabled"];
        },
    },

    mounted() {
        this.$store.dispatch("profile/refreshDashboard");
    },

    methods: {
        hasStatus(status) {
            return this.profileStatuses.includes(status);
        },
    },
};
</script>
