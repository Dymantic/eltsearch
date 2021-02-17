<template>
    <div>
        <div>
            <p class="type-h3">My Job Search</p>
            <p class="my-6 max-w-xl">
                <span class="type-b2">Note: </span>You may remove criteria from
                your search if you decide that you don't want your results
                limited by that specific criteria.
            </p>
            <div class="flex flex-col">
                <job-locations
                    v-show="useCriteria('location')"
                    v-model="formData.location"
                    :class="orderPosition('location')"
                    @dismiss="clearCriteria('location', 'area_ids', [])"
                ></job-locations>
                <student-types
                    v-show="useCriteria('students')"
                    v-model="formData.student_ages"
                    :class="orderPosition('students')"
                    @dismiss="clearCriteria('students', 'student_ages', [])"
                ></student-types>
                <benefits-wanted
                    v-show="useCriteria('benefits')"
                    v-model="formData.benefits"
                    :class="orderPosition('benefits')"
                    @dismiss="clearCriteria('benefits', 'benefits', [])"
                ></benefits-wanted>
                <contract-required
                    v-show="useCriteria('contract')"
                    v-model="formData.contract_type"
                    :class="orderPosition('contract')"
                    @dismiss="clearCriteria('contract', 'contract_type', [])"
                ></contract-required>
                <weekly-hours
                    v-show="useCriteria('hours')"
                    v-model="formData.hours_per_week"
                    :class="orderPosition('hours')"
                    @dismiss="clearCriteria('hours', 'hours_per_week', null)"
                ></weekly-hours>
                <salary-wanted
                    v-show="useCriteria('salary')"
                    v-model="formData.salary"
                    :class="orderPosition('salary')"
                    @dismiss="clearCriteria('salary', 'salary', null)"
                ></salary-wanted>
                <work-weekends
                    v-show="useCriteria('weekends')"
                    v-model="formData.weekends"
                    :class="orderPosition('weekends')"
                    @dismiss="clearCriteria('weekends', 'weekends', null)"
                ></work-weekends>
                <schedule-times
                    v-show="useCriteria('schedule')"
                    v-model="formData.schedule"
                    :class="orderPosition('schedule')"
                    @dismiss="clearCriteria('schedule', 'schedule', [])"
                ></schedule-times>
                <engagement-type
                    v-show="useCriteria('engagement')"
                    v-model="formData.engagement"
                    :class="orderPosition('engagement')"
                    @dismiss="clearCriteria('engagement', 'engagement', null)"
                ></engagement-type>
            </div>

            <div>
                <p class="my-6">{{ criteria_prompt }}</p>
                <div class="flex flex-wrap">
                    <button
                        class="px-4 py-2 border border-gray-300 mr-6 mb-6"
                        @click="used_criteria.push(criteria)"
                        v-for="criteria in available_criteria"
                    >
                        <span class="font-bold">{{
                            criteriaName(criteria)
                        }}</span>
                    </button>
                </div>
            </div>
        </div>
        <div>
            <submit-button
                :waiting="waiting"
                role="button"
                @click.native="submit"
                >Save Job Search</submit-button
            >
        </div>
    </div>
</template>

<script type="text/babel">
import JobLocations from "./JobLocations";
import StudentTypes from "./StudentTypes";
import BenefitsWanted from "./BenefitsWanted";
import ContractRequired from "./ContractRequired";
import WeeklyHours from "./WeeklyHours";
import SalaryWanted from "./SalaryWanted";
import WorkWeekends from "./WorkWeekends";
import ScheduleTimes from "./ScheduleTimes";
import EngagementType from "./EngagementType";
import SubmitButton from "../Forms/SubmitButton";
import { showError, showSuccess } from "../../../libs/notifications";
export default {
    components: {
        JobLocations,
        StudentTypes,
        BenefitsWanted,
        ContractRequired,
        WeeklyHours,
        SalaryWanted,
        WorkWeekends,
        ScheduleTimes,
        EngagementType,
        SubmitButton,
    },

    props: ["search", ""],

    data() {
        return {
            all_criteria: [
                "location",
                "students",
                "benefits",
                "contract",
                "weekends",
                "hours",
                "salary",
                "schedule",
                "engagement",
            ],
            used_criteria: this.search.used_criteria || [],
            ready: false,
            waiting: false,
            formData: {
                location: {
                    areas: this.search.area_ids || [],
                    regions: this.search.region_ids || [],
                },
                student_ages: this.search.student_ages || [],
                benefits: this.search.benefits || [],
                contract_type: this.search.contract_type || [],
                hours_per_week: this.search.hours_per_week,
                salary: this.search.salary,
                weekends: this.search.weekends,
                schedule: this.search.schedule || [],
                engagement: this.search.engagement || null,
            },
        };
    },

    computed: {
        available_criteria() {
            return this.all_criteria.filter(
                (criterion) => !this.used_criteria.includes(criterion)
            );
        },

        criteria_prompt() {
            if (this.used_criteria.length === 0) {
                return "Get started by choosing a criteria below to begin creating your search:";
            }

            return "You may add more criteria from below:";
        },

        preparedData() {
            return {
                ...this.formData,
                area_ids: this.formData.location.areas,
                region_ids: this.formData.location.regions,
            };
        },
    },

    mounted() {},

    methods: {
        useCriteria(criterion) {
            return this.used_criteria.includes(criterion);
        },

        clearCriteria(criteria, formField, value) {
            this.used_criteria = this.used_criteria.filter(
                (crit) => crit !== criteria
            );
            this.formData[formField] = value;
        },

        criteriaName(label) {
            const lookup = {
                location: "Location",
                students: "Student Ages",
                benefits: "Job Benefits",
                contract: "Contract Length",
                weekends: "Weekend Work",
                hours: "Hours",
                salary: "Salary",
                schedule: "Schedule",
                engagement: "Part time/Full time",
            };

            return lookup[label];
        },

        orderPosition(criterion) {
            if (!this.used_criteria.includes(criterion)) {
                return "order-10";
            }

            return `order-${this.used_criteria.indexOf(criterion) + 1}`;
        },

        submit() {
            this.waiting = true;

            this.$store
                .dispatch("placements/updateJobSearch", this.preparedData)
                .then(this.onSuccess)
                .catch(this.onError)
                .then(() => (this.waiting = false));
        },

        onSuccess() {
            showSuccess("Your job search has been updated");
            this.$emit("updated");
        },

        onError() {
            showError("Failed to save your job search");
        },
    },
};
</script>
