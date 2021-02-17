<template>
    <form @submit.prevent="submit" v-if="options && schoolId">
        <labeled-box :dismissable="false" :label="trns('job_post_form.job')">
            <text-field
                class="my-6 max-w-md"
                :label="trns('job_post_form.job_title')"
                v-model="formData.position"
                :error-msg="formErrors.position"
            ></text-field>

            <textarea-field
                class="my-6 max-w-lg"
                :label="trns('job_post_form.description')"
                v-model="formData.description"
                :error-msg="formErrors.description"
                height="h-40"
            ></textarea-field>

            <div class="mt-6">
                <p class="font-bold mb-2">
                    {{ trns("job_post_form.start_date_prompt") }}
                </p>
                <date-picker
                    v-model="formData.start_date"
                    input-class="border-gray-300 border p-2"
                ></date-picker>
            </div>
        </labeled-box>

        <labeled-box :dismissable="false" :label="trns('job_post_form.school')">
            <text-field
                class="my-6 max-w-md"
                :label="trns('job_post_form.school_name')"
                v-model="formData.school_name"
                :error-msg="formErrors.school_name"
            ></text-field>
            <div class="mt-6">
                <p class="font-bold mb-2">
                    {{ trns("job_post_form.location_prompt") }}
                </p>
                <div class="flex justify-between max-w-md">
                    <p>{{ current_location }}</p>
                    <choose-location
                        :label="trns('job_post_form.set_location')"
                        @chosen="setArea"
                        :heading="trns('job_post_form.location_prompt')"
                    ></choose-location>
                </div>
            </div>
        </labeled-box>

        <labeled-box
            :dismissable="false"
            :label="trns('job_post_form.engagement')"
        >
            <p class="font-bold">
                {{ trns("job_post_form.engagement_prompt") }}
            </p>
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
                    {{ trns("job_post_form.hours_prompt") }}
                </p>
                <div class="">
                    <span class="mb-2 font-bold text-sm">{{
                        trns("job_post_form.hours")
                    }}</span>
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
                    {{ trns("job_post_form.weekends_prompt") }}
                </p>
                <div class="flex">
                    <radio-input
                        v-model="formData.work_on_weekends"
                        :label="trns('job_post_form.yes')"
                        :value="true"
                        name="weekends"
                        class="mr-8"
                    ></radio-input>
                    <radio-input
                        v-model="formData.work_on_weekends"
                        :label="trns('job_post_form.no')"
                        name="weekends"
                        :value="false"
                    ></radio-input>
                </div>
            </div>

            <div class="mt-6">
                <p class="font-bold mb-2">
                    {{ trns("job_post_form.times_prompt") }}
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

        <labeled-box
            :dismissable="false"
            :label="trns('job_post_form.students')"
        >
            <div>
                <p class="font-bold mb-2">
                    {{ trns("job_post_form.student_age_prompt") }}
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
                    {{ trns("job_post_form.student_number_prompt") }}
                </p>

                <div class="flex">
                    <div class="mr-8">
                        <number-field
                            class="w-24"
                            :label="trns('job_post_form.min')"
                            v-model="formData.min_students_per_class"
                        ></number-field>
                    </div>
                    <div class="">
                        <number-field
                            class="w-24"
                            :label="trns('job_post_form.max')"
                            v-model="formData.max_students_per_class"
                        ></number-field>
                    </div>
                </div>
            </div>
        </labeled-box>

        <labeled-box
            :dismissable="false"
            :label="trns('job_post_form.requirements')"
        >
            <p class="mt-6 font-bold mb-2">
                {{ trns("job_post_form.requirements_prompt") }}
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

        <labeled-box :dismissable="false" :label="trns('job_post_form.salary')">
            <p class="mt-6 font-bold mb-2">
                {{ trns("job_post_form.salary_rate_prompt") }}
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
                {{ trns("job_post_form.salary_total_prompt") }}
            </p>
            <div class="flex">
                <div class="mr-8">
                    <number-field
                        class="w-32"
                        :label="trns('job_post_form.min')"
                        v-model="formData.salary_min"
                    ></number-field>
                </div>
                <div class="">
                    <number-field
                        class="w-32"
                        :label="trns('job_post_form.max')"
                        v-model="formData.salary_max"
                    ></number-field>
                </div>
            </div>
        </labeled-box>

        <labeled-box
            :dismissable="false"
            :label="trns('job_post_form.benefits')"
        >
            <p class="mt-6 font-bold mb-2">
                {{ trns("job_post_form.benefits_prompt") }}
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

        <labeled-box
            :dismissable="false"
            :label="trns('job_post_form.contract')"
        >
            <p class="font-bold mb-2">
                {{ trns("job_post_form.contract_prompt") }}
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

        <div class="flex">
            <submit-button :waiting="waiting">{{
                trns("job_post_form.submit")
            }}</submit-button>

            <submit-button
                :waiting="waiting"
                class="mx-4"
                role="button"
                @click.native="saveAndPublish"
                >{{ trns("job_post_form.submit_and_publish") }}</submit-button
            >
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

    props: ["options", "school-id", "post", "school-name"],

    data() {
        return {
            waiting: false,
            formData: {
                school_name: this.schoolName,
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
                return this.trns("job_post_form.no_location");
            }

            const loc = this.$store.getters["locations/area_info"](
                this.formData.area_id
            );

            if (!loc) {
                return this.trns("job_post_form.no_location");
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

        setArea({ id }) {
            this.formData.area_id = id;
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
                .then(() => showSuccess(this.trns("job_post_form.success")))
                .catch(this.onError)
                .then(() => (this.waiting = false));
        },

        saveAndPublish() {
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
                .then(this.onSuccess)
                .catch(this.onError)
                .then(() => (this.waiting = false));
        },

        onSuccess(post) {
            console.log({ post });
            showSuccess(this.trns("job_post_form.success"));
            this.$router.push(`/job-posts/${post.id}/publish`);
        },

        onError({ status, data }) {
            if (status === 422) {
                this.formErrors = setValidationErrors(
                    this.formErrors,
                    data.errors
                );
                return showWarning(this.trns("errors.invalid_input"));
            }
            showError(this.trns("errors.save_failed"));
        },
    },
};
</script>
