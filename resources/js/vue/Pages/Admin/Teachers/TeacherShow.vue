<template>
    <div>
        <page-header title="Teacher Profile"></page-header>

        <div v-if="teacher">
            <teacher-profile :teacher="teacher"></teacher-profile>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../../Components/PageHeader";
import { showError } from "../../../../libs/notifications";
import TeacherProfile from "../../../Components/Admin/Teachers/TeacherProfile";
export default {
    components: { TeacherProfile, PageHeader },

    data() {
        return {
            fetching: true,
            teacher: null,
        };
    },

    mounted() {
        this.$store
            .dispatch("teachers/fetchById", this.$route.params.teacher)
            .then((teacher) => (this.teacher = teacher))
            .catch(() => showError("Failed to find teacher"))
            .then(() => (this.fetching = false));
    },
};
</script>
