<template>
    <span>
        <button @click="showForm = true">
            <edit-icon
                v-if="region"
                class="h-3 text-gray-600 hover:text-sky-blue"
            ></edit-icon>
            <span v-else>Add Region</span>
        </button>
        <modal :show="showForm" @close="showForm = false">
            <form @submit.prevent="submit" class="w-screen max-w-md p-6">
                <p class="text-lg font-bold">
                    {{ form_title }}
                </p>
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
import EditIcon from "../Icons/EditIcon";
import {
    clearValidationErrors,
    setValidationErrors,
} from "../../../libs/forms";
import { showError, showSuccess } from "../../../libs/notifications";
export default {
    components: { Modal, TextField, SubmitButton, EditIcon },

    props: ["country", "region"],

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
            return this.region
                ? `Rename ${this.region.name.en}`
                : `Add a region to ${this.country.name.en}`;
        },

        button_text() {
            return this.region ? `Rename` : `Add Region`;
        },
    },

    mounted() {
        if (this.region) {
            this.formData = {
                name: this.region.name,
            };
        }
    },

    methods: {
        submit() {
            this.waiting = true;
            this.formErrors = clearValidationErrors(this.formErrors);
            const action = this.region
                ? "locations/updateRegion"
                : "locations/addRegion";
            const payload = this.region
                ? { region_id: this.region.id, name: this.formData }
                : { country_id: this.country.id, name: this.formData };
            this.$store
                .dispatch(action, payload)
                .then(this.onSuccess)
                .catch(this.onError)
                .then(() => {
                    this.waiting = false;
                });
        },

        onSuccess() {
            if (!this.region) {
                this.formData = {
                    name: { en: "", zh: "" },
                };
            }

            showSuccess("Region saved.");
            this.showForm = false;
        },

        onError({ status, data }) {
            if (status === 422) {
                return (this.formErrors = setValidationErrors(
                    this.formErrors,
                    data.errors
                ));
            }

            showError("Failed to save region");
        },
    },
};
</script>
