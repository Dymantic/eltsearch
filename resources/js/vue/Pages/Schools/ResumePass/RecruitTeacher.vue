<template>
    <div>
        <page-header :title="trns('recruit.title')"></page-header>

        <busy-loading v-if="!teacher"></busy-loading>

        <div class="my-12" v-if="teacher">
            <div class="flex items-center mb-6">
                <div class="w-16 h-16 mr-4">
                    <img
                        :src="teacher.avatar"
                        class="w-full h-full object-cover rounded-full"
                    />
                </div>
                <div>
                    <p class="type-a1 mb-1">{{ teacher.name }}</p>
                    <p class="type-b2">{{ teacher.nationality }}</p>
                </div>
            </div>
            <div
                v-if="recentAttempts.length > 0"
                class="my-6 border border-green-700 bg-green-100 rounded-lg p-4 max-w-lg"
            >
                <p>
                    {{
                        trns("recruit.previous_contacts", "", {
                            name: teacher.name,
                        })
                    }}
                </p>
                <ul class="list-disc list-inside type-b4">
                    <li v-for="attempt in recentAttempts" :key="attempt.id">
                        {{ attempt.created_at }}
                    </li>
                </ul>
                <p class="my-3">
                    {{ trns("recruit.warning") }}
                </p>
            </div>

            <div
                class="border border-red-700 bg-red-100 rounded-lg p-4 max-w-lg"
                v-if="recentAttempts.length > 2"
            >
                <p>
                    {{ trns("recruit.forbidden", "", { name: teacher.name }) }}
                </p>
            </div>
            <recruitment-attempt-form
                v-if="recentAttempts.length < 3"
                :teacher="teacher"
            ></recruitment-attempt-form>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../../Components/PageHeader";
import RecruitmentAttemptForm from "../../../Components/Schools/ResumePass/RecruitmentAttemptForm";
import BusyLoading from "../../../Components/BusyLoading";
import { fetchTeacherBySlug } from "../../../../api/schools/teachers";
import { showError } from "../../../../libs/notifications";
export default {
    components: { BusyLoading, RecruitmentAttemptForm, PageHeader },

    data() {
        return {
            teacher: null,
        };
    },

    computed: {
        schoolId() {
            return this.$store.state.profile.current_school_id;
        },

        recentAttempts() {
            if (!this.teacher) {
                return [];
            }
            return this.$store.getters["recruitments/forTeacher"](
                this.teacher.slug
            );
        },
    },

    mounted() {
        this.fetchTeacher();
        this.$store.dispatch("recruitments/fetch");
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
