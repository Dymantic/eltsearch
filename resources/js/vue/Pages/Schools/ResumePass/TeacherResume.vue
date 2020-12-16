<template>
    <div>
        <page-header title="Teacher Resume"></page-header>
        <busy-loading v-if="!teacher"></busy-loading>

        <div class="my-12" v-if="teacher">
            <general-profile :teacher="teacher"></general-profile>

            <div class="my-12">
                <div class="border-b border-gray-300 pb-3 mb-3">
                    <p class="type-h4 text-navy">Education</p>
                </div>
                <p>{{ teacher.education_level }}</p>
                <p class="type-a1">{{ teacher.education_qualification }}</p>
                <p>{{ teacher.education_institution }}</p>
            </div>

            <div class="my-12">
                <div class="border-b border-gray-300 pb-3 mb-3">
                    <p class="type-h4 text-navy">Work Experience</p>
                </div>
                <p v-show="!teacher.previous_employment.length">
                    {{ teacher.name }} has not entered any previous jobs.
                </p>
                <div v-for="job in teacher.previous_employment" class="mb-6">
                    <p class="type-a1">{{ job.job_title }}</p>
                    <p>
                        <span class="type-b2">Company: </span>{{ job.employer }}
                    </p>
                    <p><span class="type-b2">When: </span>{{ job.duration }}</p>
                    <p class="my-2">{{ job.descriptions }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../../Components/PageHeader";
import BusyLoading from "../../../Components/BusyLoading";
import { fetchTeacherBySlug } from "../../../../api/schools/teachers";
import { showError } from "../../../../libs/notifications";
import GeneralProfile from "./GeneralProfile";
export default {
    components: { GeneralProfile, BusyLoading, PageHeader },

    data() {
        return {
            teacher: null,
        };
    },

    computed: {
        schoolId() {
            return this.$store.state.profile.current_school_id;
        },
    },

    mounted() {
        this.fetchTeacher();
    },

    methods: {
        fetchTeacher() {
            fetchTeacherBySlug(this.schoolId, this.$route.params.teacher)
                .then((teacher) => (this.teacher = teacher))
                .catch(() => showError("Unable to find teacher."));
        },
    },
};
</script>
