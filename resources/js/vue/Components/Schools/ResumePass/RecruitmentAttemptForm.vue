<template>
    <form @submit.prevent="submit" class="max-w-lg">
        <p class="my-4">
            Send a message to <span class="type-b2">{{ teacher.name }}</span> if
            you'd like them to get in touch. Once they have read your message
            they will be able to contact you.
        </p>
        <textarea-field
            class="my-6"
            label="Your message"
            v-model="formData.message"
            :error-msg="formErrors.message"
            height="h-40"
        ></textarea-field>

        <input-field
            class="my-6"
            label="Contact person name"
            v-model="formData.contact_person"
            :error-msg="formErrors.contact_person"
            help-text="Who should the teacher contact?"
        ></input-field>

        <input-field
            class="my-6"
            label="Email address"
            v-model="formData.email"
            :error-msg="formErrors.email"
        ></input-field>

        <input-field
            class="my-6"
            label="Phone number"
            v-model="formData.phone"
            :error-msg="formErrors.phone"
        ></input-field>

        <submit-button :waiting="waiting">Send message</submit-button>
    </form>
</template>

<script type="text/babel">
import TextareaField from "../../Forms/TextareaField";
import {
    clearValidationErrors,
    setValidationErrors,
} from "../../../../libs/forms";
import { showError, showSuccess } from "../../../../libs/notifications";
import InputField from "../../Forms/InputField";
import SubmitButton from "../../Forms/SubmitButton";
export default {
    components: { SubmitButton, InputField, TextareaField },

    props: ["teacher"],

    data() {
        return {
            waiting: false,
            formData: {
                message: "",
                contact_person: this.$store.state.profile.name,
                email: this.$store.state.profile.email,
                phone: "",
            },
            formErrors: {
                message: "",
                contact_person: "",
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
                .dispatch("recruitments/recruitTeacher", {
                    teacher_slug: this.teacher.slug,
                    formData: this.formData,
                })
                .then(this.onSuccess)
                .catch(this.onError)
                .then(() => (this.waiting = false));
        },

        onSuccess() {
            showSuccess("Message sent to teacher");
            this.$router.push(`/resume-pass/teachers/${this.teacher.slug}`);
        },

        onError({ status, data }) {
            if (status === 422) {
                return (this.formErrors = setValidationErrors(
                    this.formErrors,
                    data.errors
                ));
            }
            showError("Unable to contact teacher");
        },
    },
};
</script>
