<template>
    <form @submit.prevent="submit">
        <text-field
            class="my-6 max-w-md"
            :label="trns('billing.address_label')"
            v-model="formData.address"
            :error-msg="formErrors.address"
        ></text-field>

        <text-field
            class="my-6 max-w-md"
            :label="trns('billing.city_label')"
            v-model="formData.city"
            :error-msg="formErrors.city"
        ></text-field>

        <text-field
            class="my-6 max-w-md"
            :label="trns('billing.zip_label')"
            v-model="formData.zip"
            :error-msg="formErrors.zip"
        ></text-field>

        <select-field
            class="w-64"
            v-model="formData.country"
            :error-msg="formErrors.country"
            :options="{ TW: 'Taiwan' }"
            :label="trns('billing.country_label')"
            help-text=""
            empty="--"
        ></select-field>

        <div class="my-8">
            <submit-button :waiting="waiting">{{
                trns("billing.submit")
            }}</submit-button>
        </div>
    </form>
</template>

<script type="text/babel">
import TextField from "../Forms/TextField";
import SelectField from "../Forms/SelectField";
import SubmitButton from "../Forms/SubmitButton";
import {
    clearValidationErrors,
    setValidationErrors,
} from "../../../libs/forms";
import { showError, showSuccess } from "../../../libs/notifications";

export default {
    components: { SubmitButton, SelectField, TextField },

    props: ["school"],

    data() {
        return {
            waiting: false,
            formData: {
                address: this.school.billing_address || "",
                country: this.school.billing_country || "",
                zip: this.school.billing_zip || "",
                city: this.school.billing_city || "",
                state: this.school.billing_state || "",
            },
            formErrors: {
                address: "",
                country: "",
                zip: "",
                city: "",
                state: "",
            },
        };
    },

    methods: {
        submit() {
            this.waiting = true;
            this.formErrors = clearValidationErrors(this.formErrors);

            this.$store
                .dispatch("schoolprofile/updateBillingInfo", {
                    school_id: this.school.id,
                    formData: this.formData,
                })
                .then(this.onSuccess)
                .catch(this.onError)
                .then(() => (this.waiting = false));
        },

        onSuccess() {
            showSuccess(this.trns("billing.success"));
        },

        onError({ status, data }) {
            if (status === 422) {
                return (this.formErrors = setValidationErrors(
                    this.formErrors,
                    data.errors
                ));
            }
            showError(this.trns("errors.update_billing"));
        },
    },
};
</script>
