<template>
    <form @submit.prevent="submit">
        <text-field
            class="my-6 max-w-md"
            v-model="formData.name"
            :error-msg="formErrors.name"
            label="Your name"
        ></text-field>

        <text-field
            class="my-6 max-w-md"
            type="email"
            v-model="formData.email"
            :error-msg="formErrors.email"
            label="Your email address"
            help-text="This is how schools will get in touch"
        ></text-field>

        <select-field
            class="my-6 max-w-md"
            v-model="formData.nation_id"
            :error-msg="formErrors.nation_id"
            label="Your nationality"
            :options="nations"
            help-text="The country where you have citizenship, as per your passport"
        ></select-field>

        <text-field
            class="my-6 max-w-md"
            v-show="formData.nation_id === 'xxx'"
            v-model="formData.nation_other"
            :error-msg="formErrors.nation_other"
            label="Where are you from?"
            help-text="This should be the nationality as per your passport"
        ></text-field>

        <text-field
            class="my-6 max-w-md"
            v-model="formData.date_of_birth"
            :error-msg="formErrors.date_of_birth"
            label="Date of birth"
            help-text="Please enter the date as YYYY-MM-DD"
        ></text-field>

        <text-field
            class="my-6 max-w-md"
            v-model="formData.native_language"
            :error-msg="formErrors.native_language"
            label="Native language"
        ></text-field>

        <text-field
            class="my-6 max-w-md"
            v-model="formData.other_languages"
            :error-msg="formErrors.other_languages"
            label="Other languages"
            help-text="Languages you speak confidently, other than your native language"
        ></text-field>

        <text-field
            class="my-6 max-w-md"
            v-model="formData.years_experience"
            :error-msg="formErrors.years_experience"
            label="Years of teaching experience"
            help-text="How many years of actual teaching experience do you have?"
            type="number"
            min-width="true"
        ></text-field>

        <div class="my-6">
            <submit-button :waiting="waiting">Update Info</submit-button>
        </div>
    </form>
</template>

<script type="text/babel">
import PageHeader from "../PageHeader";
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
        PageHeader,
        TextField,
        SelectField,
        SubmitButton,
    },

    props: ["info", "nations"],

    data() {
        return {
            waiting: false,
            formData: {
                name: this.info.name,
                nation_id:
                    !this.info.nation_id && this.info.nation_other
                        ? "xxx"
                        : this.info.nation_id,
                nation_other: this.info.nation_other,
                date_of_birth: this.info.date_of_birth,
                email: this.info.email,
                native_language: this.info.native_language,
                other_languages: this.info.other_languages,
                years_experience: this.info.years_experience,
            },
            formErrors: {
                name: "",
                nation_id: "",
                nation_other: "",
                date_of_birth: "",
                email: "",
                native_language: "",
                other_languages: "",
                years_experience: "",
            },
        };
    },

    methods: {
        submit() {
            this.waiting = true;
            this.formErrors = clearValidationErrors(this.formErrors);
            this.$store
                .dispatch("profile/updateGeneralInfo", this.submissionData())
                .then(this.onSuccess)
                .catch(this.onError)
                .then(() => (this.waiting = false));
        },

        submissionData() {
            const data = { ...this.formData };
            if (data.nation_id === "xxx") {
                data.nation_id = null;
            }
            return data;
        },

        onSuccess() {
            showSuccess("Your info has been updated.");
            this.$router.push("/profile");
        },

        onError({ status, data }) {
            if (status === 422) {
                this.formErrors = setValidationErrors(
                    this.formErrors,
                    data.errors
                );
                return showWarning("Some of your data is invalid");
            }
            return showError("Unable to update your info.");
        },
    },
};
</script>
