<template>
    <form @submit.prevent="submit" class="max-w-md my-12">
        <text-field
            class="my-6"
            label="Type of School (English)"
            v-model="formData.name.en"
            :error-msg="formErrors.name"
        ></text-field>

        <text-field
            class="my-6"
            label="Type of School (Chinese)"
            v-model="formData.name.zh"
        ></text-field>

        <div>
            <submit-button :waiting="waiting">Add School Type</submit-button>
        </div>
    </form>
</template>

<script type="text/babel">
import PageHeader from "../PageHeader";
import TextField from "../Forms/TextField";
import SubmitButton from "../Forms/SubmitButton";
import {
    clearValidationErrors,
    setValidationErrors,
} from "../../../libs/forms";
import { showError, showSuccess } from "../../../libs/notifications";

export default {
    components: {
        PageHeader,
        TextField,
        SubmitButton,
    },

    props: ["type"],

    data() {
        return {
            waiting: false,
            formData: {
                name: { en: "", zh: "" },
            },
            formErrors: {
                name: "",
            },
        };
    },

    mounted() {
        if (this.type) {
            this.formData = {
                name: { en: this.type.name.en, zh: this.type.name.zh },
            };
        }
    },

    methods: {
        submit() {
            this.waiting = true;
            this.formErrors = clearValidationErrors(this.formErrors);

            const action = this.type
                ? "schooltypes/updateType"
                : "schooltypes/createSchoolType";
            const payload = this.type
                ? {
                      type_id: this.type.id,
                      formData: this.formData,
                  }
                : this.formData;

            this.$store
                .dispatch(action, payload)
                .then(this.onSuccess)
                .catch(this.onError)
                .then(() => (this.waiting = false));
        },

        onSuccess() {
            if (!this.type) {
                this.formData = { name: { en: "", zh: "" } };
            }

            showSuccess("School types updated");
            this.$router.push("/school-types");
        },

        onError({ status, data }) {
            if (status === 422) {
                return (this.formErrors = setValidationErrors(
                    this.formErrors,
                    data.errors
                ));
            }
            showError("Unable to save school type");
        },
    },
};
</script>
