<template>
    <div>
        <page-header title="Teacher Profile">
            <delete-confirmation
                v-if="can_disable"
                @confirmed="disable"
                btn-text="Disable profile"
                mode="primary"
                :disabled="waiting_on_disable"
                :message="`You are about to disable the profile of ${teacher_name}. They will no longer be visible or active on the site.`"
                >Disable</delete-confirmation
            >
            <delete-confirmation
                v-if="can_reinstate"
                @confirmed="reinstate"
                btn-text="Reinstate profile"
                mode="primary"
                :disabled="waiting_on_reinstate"
                :message="`You are about to reinstate the profile of ${teacher_name}. They will once again have full access to the teacher functions.`"
                >Reinstate</delete-confirmation
            >
        </page-header>

        <div v-if="teacher">
            <teacher-profile :teacher="teacher"></teacher-profile>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../../Components/PageHeader";
import { showError, showSuccess } from "../../../../libs/notifications";
import TeacherProfile from "../../../Components/Admin/Teachers/TeacherProfile";
import DeleteConfirmation from "../../../Components/DeleteConfirmation";
import {
    disableTeacher,
    reinstateTeacher,
} from "../../../../api/admin/teachers";
export default {
    components: { DeleteConfirmation, TeacherProfile, PageHeader },

    data() {
        return {
            fetching: true,
            teacher: null,
            waiting_on_disable: false,
            waiting_on_reinstate: false,
        };
    },

    computed: {
        teacher_name() {
            return this.teacher ? this.teacher.name : "this teacher";
        },

        can_disable() {
            return this.teacher && !this.teacher.is_disabled;
        },

        can_reinstate() {
            return this.teacher && this.teacher.is_disabled;
        },
    },

    mounted() {
        this.fetch();
    },

    methods: {
        fetch() {
            this.fetching = true;
            this.$store
                .dispatch("teachers/fetchById", {
                    teacher_id: this.$route.params.teacher,
                    force: true,
                })
                .then((teacher) => (this.teacher = teacher))
                .catch(() => showError("Failed to find teacher"))
                .then(() => (this.fetching = false));
        },

        disable() {
            this.waiting_on_disable = true;
            disableTeacher(this.teacher.id)
                .then(() => {
                    this.fetch();
                    showSuccess("Profile disabled.");
                    this.$store.dispatch("teachers/refresh");
                })
                .catch(() => showError("Unable to disable teacher"))
                .then(() => (this.waiting_on_disable = false));
        },

        reinstate() {
            this.waiting_on_reinstate = true;
            reinstateTeacher(this.teacher.id)
                .then(() => {
                    this.fetch();
                    showSuccess("Profile reinstated.");
                    this.$store.dispatch("teachers/refresh");
                })
                .catch(() => showError("Unable to reinstate teacher"))
                .then(() => (this.waiting_on_reinstate = false));
        },
    },
};
</script>
