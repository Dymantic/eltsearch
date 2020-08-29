<template>
    <span>
        <button @click="showForm = true">
            <span v-if="area">rename</span>
            <span v-else>Add Area</span>
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
import {
    clearValidationErrors,
    setValidationErrors,
} from "../../../libs/forms";
import { showError, showSuccess } from "../../../libs/notifications";
export default {
    components: { Modal, TextField, SubmitButton },

    props: ["region", "area"],

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
            return this.area
                ? `Rename ${this.area.name.en}`
                : `Add an area for ${this.region.name.en}`;
        },

        button_text() {
            return this.area ? `Rename` : `Add Area`;
        },
    },

    mounted() {
        if (this.area) {
            this.formData = { name: this.area.name };
        }
    },

    methods: {
        submit() {
            this.waiting = true;
            this.formErrors = clearValidationErrors(this.formErrors);
            const action = this.area
                ? "locations/updateArea"
                : "locations/addArea";
            const payload = this.area
                ? { area_id: this.area.id, name: this.formData }
                : { region_id: this.region.id, name: this.formData };
            this.$store
                .dispatch(action, payload)
                .then(this.onSuccess)
                .catch(this.onError)
                .then(() => {
                    this.waiting = false;
                });
        },

        onSuccess() {
            if (!this.area) {
                this.formData = {
                    name: { en: "", zh: "" },
                };
            }

            showSuccess("Area saved.");
            this.showForm = false;
        },

        onError({ status, data }) {
            if (status === 422) {
                return (this.formErrors = setValidationErrors(
                    this.formErrors,
                    data.errors
                ));
            }

            showError("Failed to save area");
        },
    },
};
</script>
