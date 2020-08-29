<template>
    <div>
        <form @submit.prevent="submit">
            <text-field
                class="my-6 max-w-md"
                v-model="formData.employer"
                :error-msg="formErrors.employer"
                label="Employer"
                help-text="The name of the company or institution your worked for."
            ></text-field>

            <div>
                <p class="font-bold text-sm mb-2">Start of employment</p>
                <div class="flex items-center">
                    <select-field
                        class="w-20"
                        v-model="formData.start_month"
                        :error-msg="formErrors.start_month"
                        :options="all_months"
                        label=""
                        help-text="Month"
                    ></select-field>
                    <span class="pt-6 px-4 text-gray-500"> - </span>
                    <select-field
                        class="w-32"
                        v-model="formData.start_year"
                        :options="all_years"
                        :error-msg="formErrors.start_year"
                        label=""
                        help-text="Year"
                    ></select-field>
                </div>
            </div>

            <div class="my-6">
                <p class="font-bold text-sm mb-2">End of employment</p>
                <div class="flex items-center">
                    <select-field
                        class="w-20"
                        v-model="formData.end_month"
                        :error-msg="formErrors.end_month"
                        :options="all_months"
                        label=""
                        help-text="Month"
                    ></select-field>
                    <span class="pt-6 px-4 text-gray-500"> - </span>
                    <select-field
                        class="w-32"
                        v-model="formData.end_year"
                        :options="all_years"
                        :error-msg="formErrors.end_year"
                        label=""
                        help-text="Year"
                    ></select-field>
                </div>
            </div>

            <text-field
                class="my-6 max-w-md"
                v-model="formData.job_title"
                :error-msg="formErrors.job_title"
                label="Job title"
                help-text="What role did you perform?"
            ></text-field>

            <textarea-field
                class="my-6 max-w-md"
                v-model="formData.description"
                :error-msg="formErrors.description"
                label="Description"
                help-text="Short description of your employment."
            ></textarea-field>

            <div class="my-6">
                <submit-button :waiting="waiting">{{
                    button_text
                }}</submit-button>
            </div>
        </form>
    </div>
</template>

<script type="text/babel">
import TextField from "../Forms/TextField";
import TextareaField from "../Forms/TextareaField";
import SelectField from "../Forms/SelectField";
import SubmitButton from "../Forms/SubmitButton";
import {
    clearValidationErrors,
    setValidationErrors,
} from "../../../libs/forms";
import {
    showError,
    showSuccess,
    showWarning,
} from "../../../libs/notifications";
export default {
    components: {
        TextField,
        TextareaField,
        SelectField,
        SubmitButton,
    },

    props: ["employment"],

    data() {
        return {
            waiting: false,
            formData: {
                employer: "",
                start_month: "",
                start_year: "",
                end_month: "",
                end_year: "",
                job_title: "",
                description: "",
            },
            formErrors: {
                employer: "",
                start_month: "",
                start_year: "",
                end_month: "",
                end_year: "",
                job_title: "",
                description: "",
            },
            all_months: {
                "1": "Jan",
                "2": "Feb",
                "3": "March",
                "4": "April",
                "5": "May",
                "6": "June",
                "7": "July",
                "8": "Aug",
                "9": "Sep",
                "10": "Oct",
                "11": "Nov",
                "12": "Dec",
            },
        };
    },

    computed: {
        all_years() {
            const now = new Date().getFullYear();
            return [...Array(40).keys()].reverse().reduce((years, n) => {
                years[now - n] = now - n;
                return years;
            }, {});
        },

        button_text() {
            return this.employment
                ? "Update Employment Info"
                : "Add Employment";
        },
    },

    mounted() {
        if (this.employment) {
            this.setForm();
        }
    },

    methods: {
        setForm() {
            this.formData = {
                employer: this.employment.employer,
                start_month: this.employment.start_month,
                start_year: this.employment.start_year,
                end_month: this.employment.end_month,
                end_year: this.employment.end_year,
                job_title: this.employment.job_title,
                description: this.employment.description,
            };
        },

        submit() {
            this.waiting = true;
            this.formErrors = clearValidationErrors(this.formErrors);

            this.employment ? this.update() : this.create();
        },

        create() {
            this.$store
                .dispatch("profile/createPreviousEmployment", this.formData)
                .then(this.onSuccess)
                .catch(this.onError)
                .then((this.waiting = false));
        },

        update() {
            this.$store
                .dispatch("profile/updatePreviousEmployment", {
                    employment_id: this.employment.id,
                    formData: this.formData,
                })
                .then(this.onSuccess)
                .catch(this.onError)
                .then((this.waiting = false));
        },

        onSuccess() {
            if (!this.employment) {
                this.formData = {
                    employer: "",
                    start_month: "",
                    start_year: "",
                    end_month: "",
                    end_year: "",
                    job_title: "",
                    description: "",
                };
            }
            showSuccess("Employment history updated");
            this.$router.push("/previous-employments");
        },

        onError({ status, data }) {
            if (status === 422) {
                this.formErrors = setValidationErrors(
                    this.formErrors,
                    data.errors
                );
                return showWarning("Some of our input is invalid");
            }
            showError("Unable to save employment info");
        },
    },
};
</script>
