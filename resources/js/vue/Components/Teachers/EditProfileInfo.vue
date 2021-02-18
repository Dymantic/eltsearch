<template>
    <div v-if="general_info">
        <page-header title="Update your personal info" :back="true">
        </page-header>
        <div v-if="nations && general_info">
            <teacher-info-form
                :info="general_info"
                :nations="nations"
            ></teacher-info-form>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../PageHeader";
import { showError } from "../../../libs/notifications";
import TeacherInfoForm from "./TeacherInfoForm";
export default {
    components: {
        TeacherInfoForm,
        PageHeader,
    },

    computed: {
        general_info() {
            return this.$store.state.profile.general_info;
        },

        nations() {
            const all = this.$store.state.nations.all.reduce((list, nation) => {
                list[nation.id] = nation.nationality;
                return list;
            }, {});

            all["xxx"] = "Other";

            return all;
        },
    },

    created() {
        this.$store
            .dispatch("profile/fetchGeneralInfo")
            .catch(() => showError("unable to fetch profile info"));

        this.$store.dispatch("nations/fetch");
    },
};
</script>
