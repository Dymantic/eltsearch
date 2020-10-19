<template>
    <form @submit.prevent="submit" class="max-w-md">
        <text-field
            class="my-6 max-w-md"
            :label="trns('show_interest_form.name')"
            :help-text="trns('show_interest_form.name_prompt')"
            v-model="formData.contact_name"
            :error-msg="formErrors.contact_name"
        ></text-field>

        <text-field
            class="my-6 max-w-md"
            :label="trns('show_interest_form.email')"
            :help-text="trns('show_interest_form.email_prompt')"
            type="email"
            v-model="formData.email"
            :error-msg="formErrors.email"
        ></text-field>

        <text-field
            class="my-6 max-w-md"
            :label="trns('show_interest_form.phone')"
            :help-text="trns('show_interest_form.phone_prompt')"
            v-model="formData.phone"
            :error-msg="formErrors.phone"
        ></text-field>

        <div class="my-8">
            <submit-button :waiting="waiting">{{
                trns("show_interest_form.submit")
            }}</submit-button>
        </div>
    </form>
</template>

<script type="text/babel">
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
        TextField,
        SubmitButton,
    },

    props: ["application-id"],

    data() {
        return {
            waiting: false,
            formData: {
                contact_name: this.$store.state.profile.name,
                email: this.$store.state.profile.email,
                phone: "",
            },
            formErrors: {
                contact_name: "",
                email: "",
                phone: "",
            },
        };
    },

    methods: {
        submit() {
            this.waiting = true;
            this.formErrors = clearValidationErrors(this.formErrors);

            this.$store
                .dispatch("applications/showInterest", {
                    application_id: this.applicationId,
                    formData: this.formData,
                })
                .then(this.onSuccess)
                .catch(this.onError)
                .then(() => (this.waiting = false));
        },

        onSuccess() {
            showSuccess(this.trns("show_interest_form.success"));
            this.$router.push(`/applications/${this.applicationId}`);
        },

        onError({ status, data }) {
            if (status === 422) {
                this.formErrors = setValidationErrors(
                    this.formErrors,
                    data.errors
                );
                return showWarning(this.trns("errors.invalid_input"));
            }
            showError(this.trns("errors.contact_teacher"));
        },
    },
};
</script>
