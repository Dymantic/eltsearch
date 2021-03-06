<template>
    <div>
        <div
            class="my-12 grid grid-cols-1 md:grid-cols-2 p-6 rounded-lg shadow max-w-lg gap-4"
        >
            <p class="type-h4">{{ post.position }}</p>
            <p class="type-h4">{{ post.school_name }}</p>
            <p class="text-gray-600">{{ post.salary }}</p>
            <p class="text-gray-600">{{ post.area }}</p>
        </div>

        <form @submit.prevent="submit" class="my-12 max-w-lg">
            <p class="type-h4">Introduce Yourself</p>
            <textarea-field
                class="my-6"
                v-model="formData.cover_letter"
                :error-msg="formErrors.cover_letter"
                help-text="Write a few words introducing yourself and describing why you are suitable for this specific job. Be friendly and honest."
                height="h-64"
                word-limit="200"
            ></textarea-field>

            <p class="type-h4">Contact Details</p>
            <p class="mt-2 text-gray-600">
                Provide an email address and/or a phone number where the school
                can contact you, should they decide to reach out.
            </p>

            <text-field
                class="my-6"
                v-model="formData.email"
                :error-msg="formErrors.email"
                type="email"
                label="Your email address"
            ></text-field>

            <text-field
                class="my-6"
                v-model="formData.phone"
                :error-msg="formErrors.phone"
                label="Your phone number"
            ></text-field>

            <submit-button :waiting="waiting">Apply for Job</submit-button>
        </form>
    </div>
</template>

<script type="text/babel">
import TextField from "../Forms/TextField";
import TextareaField from "../Forms/TextareaField";
import SubmitButton from "../Forms/SubmitButton";
import {
    clearValidationErrors,
    setValidationErrors,
} from "../../../libs/forms";
import { showError, showSuccess } from "../../../libs/notifications";
export default {
    components: { TextareaField, TextField, SubmitButton },

    props: ["post"],

    data() {
        return {
            waiting: false,
            formData: {
                cover_letter: "",
                email: "",
                phone: "",
            },
            formErrors: {
                cover_letter: "",
                email: "",
                phone: "",
            },
        };
    },

    mounted() {
        this.formData.email = this.$store.state.profile.email;
    },

    methods: {
        submit() {
            this.waiting = true;
            this.formErrors = clearValidationErrors(this.formErrors);

            this.$store
                .dispatch("applications/apply", {
                    cover_letter: this.formData.cover_letter,
                    email: this.formData.email,
                    phone: this.formData.phone,
                    job_post_id: this.post.id,
                })
                .then(this.onSuccess)
                .catch(this.onError)
                .then(() => (this.waiting = false));
        },

        onSuccess() {
            showSuccess("You application has been sent.");
            this.$router.push(`/applications`);
        },

        onError({ status, data }) {
            if (status === 422) {
                return (this.formErrors = setValidationErrors(
                    this.formErrors,
                    data.errors
                ));
            }
            showError("Failed to send application.");
        },
    },
};
</script>
