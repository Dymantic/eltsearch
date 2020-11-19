<template>
    <div v-if="general_info">
        <page-header title="Update your personal info">
            <router-link to="/profile" class="muted-btn"
                >&larr; Back</router-link
            >
        </page-header>
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

            <text-field
                class="my-6 max-w-md"
                v-model="formData.nationality"
                :error-msg="formErrors.nationality"
                label="Your nationality"
                help-text="The country where you have citizenship, as per your passport"
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
    </div>
</template>

<script type="text/babel">
import PageHeader from "../PageHeader";
import TextField from "../Forms/TextField";
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
        SubmitButton,
    },

    data() {
        return {
            waiting: false,
            formData: {
                name: "",
                nationality: "",
                date_of_birth: "",
                email: "",
                native_language: "",
                other_languages: "",
                years_experience: null,
            },
            formErrors: {
                name: "",
                nationality: "",
                date_of_birth: "",
                email: "",
                native_language: "",
                other_languages: "",
                years_experience: "",
            },
        };
    },

    computed: {
        general_info() {
            return this.$store.state.profile.general_info;
        },
    },

    watch: {
        general_info(info) {
            if (info) {
                this.setForm();
            }
        },
    },

    created() {
        this.$store
            .dispatch("profile/fetchGeneralInfo")
            .catch(() => showError("unable to fetch profile info"));
    },

    mounted() {
        if (this.general_info) {
            this.setForm();
        }
    },

    methods: {
        setForm() {
            this.formData = {
                name: this.general_info.name,
                nationality: this.general_info.nationality,
                date_of_birth: this.general_info.date_of_birth,
                email: this.general_info.email,
                native_language: this.general_info.native_language,
                other_languages: this.general_info.other_languages,
                years_experience: this.general_info.years_experience,
            };
        },

        submit() {
            this.waiting = true;
            this.formErrors = clearValidationErrors(this.formErrors);
            this.$store
                .dispatch("profile/updateGeneralInfo", this.formData)
                .then(this.onSuccess)
                .catch(this.onError)
                .then(() => (this.waiting = false));
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
