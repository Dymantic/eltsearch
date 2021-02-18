<template>
    <div v-if="profile && types.length">
        <page-header :title="trns('edit_profile.title')" :back="true">
        </page-header>
        <school-profile-form
            :profile="profile"
            :school-types="types"
        ></school-profile-form>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
import SchoolProfileForm from "../../Components/Schools/SchoolProfileForm";
import { showError } from "../../../libs/notifications";
export default {
    components: {
        PageHeader,
        SchoolProfileForm,
    },

    computed: {
        profile() {
            return this.$store.state.schoolprofile.current_school;
        },

        types() {
            return this.$store.state.schoolprofile.school_types;
        },
    },

    mounted() {
        this.$store
            .dispatch("schoolprofile/fetchProfiles")
            .catch(() => showError(this.trns("errors.fetch_school_info")));

        this.$store
            .dispatch("schoolprofile/fetchSchoolTypes")
            .catch(() => showError(this.trns("errors.fetch_school_types")));
    },
};
</script>
