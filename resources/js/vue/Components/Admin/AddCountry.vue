<template>
    <span>
        <button
            :class="{ 'btn btn-primary': !country }"
            @click="showForm = true"
        >
            <span class="text-btn" v-if="country">Rename</span>
            <span v-else>Add Country</span>
        </button>
        <modal :show="showForm" @close="showForm = false">
            <form @submit.prevent="submit" class="w-screen max-w-md p-6">
                <p class="text-lg font-bold">{{ form_title }}</p>
                <p class="my-3 text-red-600 text-sm" v-show="formErrors.name">
                    {{ formErrors.name }}
                </p>
                <text-field
                    class="my-4"
                    label="English name"
                    v-model="formData.name.en"
                ></text-field>
                <text-field
                    class="my-4"
                    label="Chinese name"
                    v-model="formData.name.zh"
                ></text-field>
                <div class="flex justify-end mt-6">
                    <button
                        type="button"
                        @click="showForm = false"
                        class="mr-4"
                    >
                        Cancel
                    </button>
                    <submit-button :waiting="waiting">{{
                        button_text
                    }}</submit-button>
                </div>
            </form>
        </modal>
    </span>
</template>

<script type="text/babel">
import Modal from "@dymantic/modal";
import TextField from "../Forms/TextField";
import SubmitButton from "../Forms/SubmitButton";
import {
    clearValidationErrors,
    setValidationErrors,
} from "../../../libs/forms";
import { showError, showSuccess } from "../../../libs/notifications";
export default {
    components: { Modal, TextField, SubmitButton },

    props: ["country"],

    data() {
        return {
            showForm: false,
            waiting: false,
            formData: {
                name: { en: "", zh: "" },
            },
            formErrors: {
                name: "",
            },
        };
    },

    computed: {
        form_title() {
            return this.country
                ? `Rename ${this.country.name}`
                : "Add a new country for ELTSearch";
        },

        button_text() {
            return this.country ? `Rename` : "Add Country";
        },
    },

    mounted() {
        if (this.country) {
            this.formData = { name: this.country.name };
        }
    },

    methods: {
        submit() {
            this.waiting = true;
            this.formErrors = clearValidationErrors(this.formErrors);
            const action = this.country
                ? "locations/updateCountry"
                : "locations/saveCountry";
            const payload = this.country
                ? { country_id: this.country.id, name: this.formData }
                : this.formData;
            this.$store
                .dispatch(action, payload)
                .then(this.onSuccess)
                .catch(this.onError)
                .then(() => {
                    this.waiting = false;
                });
        },

        onSuccess() {
            if (!this.country) {
                this.formData = {
                    name: { en: "", zh: "" },
                };
            }

            showSuccess("Country added.");
            this.showForm = false;
        },

        onError({ status, data }) {
            if (status === 422) {
                return (this.formErrors = setValidationErrors(
                    this.formErrors,
                    data.errors
                ));
            }

            showError("Failed to save country");
        },
    },
};
</script>
