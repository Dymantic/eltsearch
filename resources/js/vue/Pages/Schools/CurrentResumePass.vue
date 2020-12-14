<template>
    <div>
        <page-header title="Your Resume Pass">
            <p v-show="passInfo.has_access" class="type-b1">
                Valid until {{ passInfo.expires_on }}
            </p>
        </page-header>

        <no-access
            :pass-info="passInfo"
            v-if="!passInfo.has_access"
        ></no-access>

        <reminder-to-extend
            :pass-info="passInfo"
            v-if="passInfo.has_access && passInfo.days_remaining < 21"
        ></reminder-to-extend>

        <busy-loading
            v-if="!teachers.length && passInfo.has_access"
        ></busy-loading>

        <div class="my-12" v-if="teachers.length && passInfo.has_access">
            <div v-for="teacher in teachers" :key="teacher.id">
                {{ teacher.name }}
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
import NoAccess from "../../Components/Schools/ResumePass/NoAccess";
import ReminderToExtend from "../../Components/Schools/ResumePass/ReminderToExtend";
import BusyLoading from "../../Components/BusyLoading";
import { queryTeachers } from "../../../api/schools/teachers";
export default {
    components: { BusyLoading, ReminderToExtend, NoAccess, PageHeader },

    data() {
        return {
            teachers: [],
        };
    },

    computed: {
        passInfo() {
            return this.$store.state.purchases.resumePass;
        },
    },

    mounted() {
        this.$store.dispatch("purchases/checkResumePass");
        this.fetchTeachers();
    },

    methods: {
        fetchTeachers() {
            queryTeachers().then((teachers) => (this.teachers = teachers));
        },
    },
};
</script>
