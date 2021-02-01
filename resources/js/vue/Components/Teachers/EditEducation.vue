<template>
    <div v-if="education">
        <p class="font-bold text-2xl mb-8">Update your education info</p>

        <form @submit.prevent="submit">
            <select-field
                class="my-6 max-w-md"
                :options="{
                    associate: 'Associate\'s Degree',
                    bachelor: 'Bachelor\'s Degree',
                    master: 'Master\'s Degree',
                    doctorate: 'Doctorate Degree',
                    other: 'Other',
                }"
                label="Level of education"
                v-model="formData.education_level"
                :error-msg="formErrors.education_level"
            >
            </select-field>
            <text-field
                class="my-6 max-w-md"
                v-model="formData.education_institution"
                :error-msg="formErrors.education_institution"
                label="Where did you receive your highest level of education?"
            ></text-field>

            <text-field
                class="my-6 max-w-md"
                v-model="formData.education_qualification"
                :error-msg="formErrors.education_qualification"
                label="What graduate or post-graduate qualification did you achieve?"
            ></text-field>

            <submit-button :waiting="waiting">
                Update Education
            </submit-button>
        </form>
    </div>
</template>

<script type="text/babel">
import TextField from "../Forms/TextField";
import SelectField from "../Forms/SelectField";
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
        TextField,
        SelectField,
        SubmitButton,
    },

    data() {
        return {
            waiting: false,
            formData: {
                education_level: "doctorate",
                education_institution: "",
                education_qualification: "",
            },
            formErrors: {
                education_level: "",
                education_institution: "",
                education_qualification: "",
            },
        };
    },

    computed: {
        education() {
            return this.$store.state.profile.education_info;
        },
    },

    watch: {
        education(info) {
            if (info) {
                this.setForm();
            }
        },
    },

    created() {
        this.$store
            .dispatch("profile/fetchEducationInfo")
            .catch(() => showError("Unable to fetch education info"));
    },

    mounted() {
        this.setForm();
    },

    methods: {
        setForm() {
            if (!this.education) {
                return;
            }

            this.formData = {
                education_level: this.education.education_level_key,
                education_institution: this.education.education_institution,
                education_qualification: this.education.education_qualification,
            };
        },

        submit() {
            this.waiting = true;
            this.formErrors = clearValidationErrors(this.formErrors);
            this.$store
                .dispatch("profile/updateEducation", this.formData)
                .then(this.onSuccess)
                .catch(this.onError)
                .then(() => (this.waiting = false));
        },

        onSuccess() {
            showSuccess("Education info updated");
            this.$router.push("/profile");
        },

        onError({ status, data }) {
            if (status === 422) {
                this.formErrors = setValidationErrors(
                    this.formErrors,
                    data.errors
                );
                return showWarning("Some of your input is invalid");
            }

            showError("Failed to save education info");
        },
    },
};
</script>
