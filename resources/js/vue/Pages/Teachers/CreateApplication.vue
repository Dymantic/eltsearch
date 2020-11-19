<template>
    <div v-if="post">
        <page-header title="Apply for job"></page-header>

        <div
            class="my-12 grid grid-cols-1 md:grid-cols-2 p-6 rounded-lg shadow max-w-lg gap-4"
        >
            <p class="type-h4">{{ post.position }}</p>
            <p class="type-h4">{{ post.school_name }}</p>
            <p class="text-gray-600">{{ post.salary }}</p>
            <p class="text-gray-600">{{ post.area }}</p>
        </div>

        <form @submit.prevent="submit" class="my-12 max-w-lg">
            <p class="type-h4">Cover Letter</p>
            <textarea-field
                class="my-6"
                v-model="formData.cover_letter"
                :error-msg="formErrors.cover_letter"
                help-text="Write a few words describing why you are suitable for this specific job. Be friendly and honest."
                height="h-32"
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
import PageHeader from "../../Components/PageHeader";
import TextareaField from "../../Components/Forms/TextareaField";
import {
    clearValidationErrors,
    setValidationErrors,
} from "../../../libs/forms";
import { showError, showSuccess } from "../../../libs/notifications";
import TextField from "../../Components/Forms/TextField";
import SubmitButton from "../../Components/Forms/SubmitButton";
export default {
    components: { SubmitButton, TextField, TextareaField, PageHeader },

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

    computed: {
        match() {
            return this.$store.getters["matches/byId"](
                this.$route.params.job_match
            );
        },

        post() {
            return this.match ? this.match.post : null;
        },
    },

    mounted() {
        this.$store.dispatch("matches/fetch");
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
