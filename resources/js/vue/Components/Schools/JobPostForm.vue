<template>
    <form @submit.prevent="submit" v-if="options && schoolId">
        <labeled-box :dismissable="false" label="Job">
            <text-field
                class="my-6 max-w-md"
                label="Job Title"
                v-model="formData.position"
                :error-msg="formErrors.position"
            ></text-field>

            <textarea-field
                class="my-6 max-w-lg"
                label="Description of Job"
                v-model="formData.description"
                :error-msg="formErrors.description"
            ></textarea-field>

            <div class="mt-6">
                <p class="font-bold mb-2">
                    When would you like the teacher to start?
                </p>
                <date-picker
                    v-model="formData.start_date"
                    input-class="border-gray-300 border p-2"
                ></date-picker>
            </div>
        </labeled-box>

        <labeled-box :dismissable="false" label="School">
            <text-field
                class="my-6 max-w-md"
                label="Name of school"
                v-model="formData.school_name"
                :error-msg="formErrors.school_name"
            ></text-field>
            <div class="mt-6">
                <p class="font-bold mb-2">Where is the school located?</p>
                <div class="flex justify-between max-w-md">
                    <p>{{ current_location }}</p>
                    <choose-location
                        label="Set location"
                        @chosen="setArea"
                    ></choose-location>
                </div>
            </div>
        </labeled-box>

        <labeled-box :dismissable="false" label="Engagement">
            <p class="font-bold">Is this job full time or part time?</p>
            <div class="flex flex-wrap max-w-md mt-2">
                <radio-input
                    v-for="engagement in options.engagements"
                    :key="engagement.value"
                    v-model="formData.engagement"
                    :value="engagement.value"
                    :label="engagement.description"
                    name="engagement"
                    class="mr-8"
                ></radio-input>
            </div>

            <div class="mt-6">
                <p class="font-bold mb-2">
                    How many hours approximately would the teacher work per
                    week?
                </p>
                <div class="">
                    <span class="mb-2 font-bold text-sm">Hours per week</span>
                    <text-field
                        class="w-24"
                        label=""
                        type="number"
                        v-model="formData.hours_per_week"
                    ></text-field>
                </div>
                <p
                    class="text-sm text-red-600"
                    v-show="formErrors.hours_per_week"
                >
                    {{ formErrors.hours_per_week }}
                </p>
            </div>

            <div class="mt-6">
                <p class="font-bold mb-2">
                    Is the teacher required to work on either Saturdays or
                    Sundays?
                </p>
                <div class="flex">
                    <radio-input
                        v-model="formData.work_on_weekends"
                        label="Yes"
                        :value="true"
                        name="weekends"
                        class="mr-8"
                    ></radio-input>
                    <radio-input
                        v-model="formData.work_on_weekends"
                        label="No"
                        name="weekends"
                        :value="false"
                    ></radio-input>
                </div>
            </div>

            <div class="mt-6">
                <p class="font-bold mb-2">
                    What time of days would the teacher be working?
                </p>
                <div class="">
                    <checkbox-input
                        v-for="schedule in options.schedule_times"
                        :key="schedule.value"
                        v-model="formData.schedule"
                        :label="schedule.description"
                        :value="schedule.value"
                    ></checkbox-input>
                </div>
            </div>
        </labeled-box>

        <labeled-box :dismissable="false" label="students">
            <div>
                <p class="font-bold mb-2">
                    What age of students would the teacher teach?
                </p>
                <div class="">
                    <checkbox-input
                        v-for="age in options.student_ages"
                        :key="age.value"
                        :label="age.description"
                        :value="age.value"
                        v-model="formData.student_ages"
                    ></checkbox-input>
                </div>

                <p class="mt-6 font-bold mb-2">
                    How many students are in each class?
                </p>

                <div class="flex">
                    <div class="mr-8">
                        <number-field
                            class="w-24"
                            label="Min"
                            v-model="formData.min_students_per_class"
                        ></number-field>
                    </div>
                    <div class="">
                        <number-field
                            class="w-24"
                            label="Max"
                            v-model="formData.max_students_per_class"
                        ></number-field>
                    </div>
                </div>
            </div>
        </labeled-box>

        <labeled-box :dismissable="false" label="requirements">
            <p class="mt-6 font-bold mb-2">
                What do you require from the teacher?
            </p>
            <div>
                <checkbox-input
                    v-for="requirement in options.requirements"
                    :key="requirement.value"
                    :label="requirement.description"
                    :value="requirement.value"
                    v-model="formData.requirements"
                ></checkbox-input>
            </div>
        </labeled-box>

        <labeled-box :dismissable="false" label="salary">
            <p class="mt-6 font-bold mb-2">
                What is the salary based on?
            </p>
            <div class="flex flex-wrap">
                <radio-input
                    class="mr-8"
                    v-for="rate in options.salary_rates"
                    :key="rate.value"
                    :value="rate.value"
                    :label="rate.description"
                    v-model="formData.salary_rate"
                    name="salary_rate"
                ></radio-input>
            </div>
            <p class="mt-6 font-bold mb-2">
                What salary are you offering?
            </p>
            <div class="flex">
                <div class="mr-8">
                    <number-field
                        class="w-32"
                        label="Min"
                        v-model="formData.salary_min"
                    ></number-field>
                </div>
                <div class="">
                    <number-field
                        class="w-32"
                        label="Max"
                        v-model="formData.salary_max"
                    ></number-field>
                </div>
            </div>
        </labeled-box>

        <labeled-box :dismissable="false" label="benefits">
            <p class="mt-6 font-bold mb-2">
                Which of these benefits do you offer?
            </p>
            <div>
                <checkbox-input
                    v-for="benefit in options.benefits"
                    :key="benefit.value"
                    :label="benefit.description"
                    :value="benefit.value"
                    v-model="formData.benefits"
                ></checkbox-input>
            </div>
        </labeled-box>

        <labeled-box :dismissable="false" label="contract">
            <p class="font-bold mb-2">
                What contract length do you offer?
            </p>
            <div class="">
                <radio-input
                    class=""
                    v-for="contract in options.contract_lengths"
                    :key="contract.value"
                    :value="contract.value"
                    :label="contract.description"
                    v-model="formData.contract_length"
                    name="contract_length"
                ></radio-input>
            </div>
        </labeled-box>

        <div>
            <submit-button :waiting="waiting">Save Job Post</submit-button>
        </div>
    </form>
</template>

<script type="text/babel">
import PageHeader from "../PageHeader";
import LabeledBox from "../LabeledBox";
import TextField from "../Forms/TextField";
import TextareaField from "../Forms/TextareaField";
import RadioInput from "../Forms/RadioInput";
import CheckboxInput from "../Forms/CheckboxInput";
import NumberField from "../Forms/NumberField";
import DatePicker from "vuejs-datepicker";
import ChooseLocation from "../Teachers/ChooseLocation";
import SubmitButton from "../Forms/SubmitButton";
import {
    showError,
    showSuccess,
    showWarning,
} from "../../../libs/notifications";
import {
    clearValidationErrors,
    setValidationErrors,
} from "../../../libs/forms";

export default {
    components: {
        PageHeader,
        LabeledBox,
        TextField,
        TextareaField,
        RadioInput,
        CheckboxInput,
        NumberField,
        DatePicker,
        ChooseLocation,
        SubmitButton,
    },

    props: ["options", "school-id", "post"],

    data() {
        return {
            waiting: false,
            formData: {
                school_name: "",
                description: "",
                area_id: null,
                position: "",
                engagement: "",
                hours_per_week: "",
                min_students_per_class: null,
                max_students_per_class: null,
                student_ages: [],
                work_on_weekends: null,
                requirements: [],
                salary_rate: "",
                salary_min: null,
                salary_max: null,
                start_date: null,
                benefits: [],
                contract_length: null,
                schedule: [],
            },
            formErrors: {
                school_name: "",
                area_id: "",
                engagement: "",
                hours_per_week: "",
                min_students_per_class_per_class: "",
                max_students_per_class_per_class: "",
                student_ages: "",
                work_on_weekends: "",
                requirements: "",
                salary_rate: "",
                salary_min: "",
                salary_max: "",
                start_date: "",
                benefits: "",
                contract_length: "",
            },
        };
    },

    computed: {
        current_location() {
            if (!this.formData.area_id) {
                return "No location set";
            }

            const loc = this.$store.getters["locations/area_info"](
                this.formData.area_id
            );

            if (!loc) {
                return "No location set";
            }

            return `${loc.area_name}, ${loc.region_name}, ${loc.country_name}`;
        },
    },

    watch: {
        post() {
            this.setForm();
        },
    },

    mounted() {
        if (this.post) {
            this.setForm();
        }
    },

    methods: {
        setForm() {
            this.formData = {
                school_name: this.post.school_name,
                description: this.post.description,
                area_id: this.post.area_id,
                position: this.post.position,
                engagement: this.post.engagement,
                hours_per_week: this.post.hours_per_week,
                min_students_per_class: this.post.min_students_per_class,
                max_students_per_class: this.post.max_students_per_class,
                student_ages: this.post.student_ages,
                work_on_weekends: this.post.work_on_weekends,
                requirements: this.post.requirements,
                salary_rate: this.post.salary_rate,
                salary_min: this.post.salary_min,
                salary_max: this.post.salary_max,
                start_date: new Date(this.post.start_date.slice(0, 10)),
                benefits: this.post.benefits,
                contract_length: this.post.contract_length,
                schedule: this.post.schedule,
            };
        },

        setArea(area_id) {
            this.formData.area_id = area_id;
        },

        submit() {
            this.waiting = true;
            this.formErrors = clearValidationErrors(this.formErrors);
            const action = this.post ? "posts/updatePost" : "posts/createPost";
            const payload = this.post
                ? {
                      school_id: this.schoolId,
                      formData: this.formData,
                      post_id: this.post.id,
                  }
                : {
                      school_id: this.schoolId,
                      formData: this.formData,
                  };
            this.$store
                .dispatch(action, payload)
                .then(() => showSuccess("Your post has been saved"))
                .catch(this.onError)
                .then(() => (this.waiting = false));
        },

        onError({ status, data }) {
            console.log({ status, data });
            if (status === 422) {
                this.formErrors = setValidationErrors(
                    this.formErrors,
                    data.errors
                );
                return showWarning("Some input was not valid");
            }
            showError("Sorry, failed to save info.");
        },
    },
};
</script>
