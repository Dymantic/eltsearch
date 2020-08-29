<template>
    <div>
        <p class="font-bold text-2xl mb-8">Choose a new password</p>
        <form @submit.prevent="submit" class="max-w-sm">
            <text-field
                type="password"
                class="my-6"
                v-model="formData.old_password"
                :error-msg="formErrors.old_password"
                label="Your Current Password"
            ></text-field>

            <text-field
                type="password"
                class="my-6"
                v-model="formData.password"
                :error-msg="formErrors.password"
                label="Choose a new password"
                help-text="At least 8 characters long."
            ></text-field>

            <text-field
                type="password"
                class="my-6"
                v-model="formData.password_confirmation"
                :error-msg="formErrors.password_confirmation"
                label="Confirm your new password"
            ></text-field>
            <div>
                <submit-button :waiting="waiting"
                    >Update Password</submit-button
                >
            </div>
        </form>
    </div>
</template>

<script type="text/babel">
import TextField from "./Forms/TextField";
import SubmitButton from "./Forms/SubmitButton";
import { resetPassword } from "../../api/auth";
import { showError, showSuccess } from "../../libs/notifications";

export default {
    components: {
        TextField,
        SubmitButton,
    },

    data() {
        return {
            waiting: false,
            formData: {
                old_password: "",
                password: "",
                password_confirmation: "",
            },
            formErrors: {
                old_password: "",
                password: "",
                password_confirmation: "",
            },
        };
    },

    methods: {
        submit() {
            this.waiting = true;
            resetPassword(this.formData)
                .then(() => {
                    this.waiting = false;
                    showSuccess("Your password has been reset");
                    this.$router.push("/");
                })
                .catch(({ status, data }) => {
                    this.waiting = false;
                    if (status === 422) {
                        Object.keys(data.errors).forEach((key) => {
                            if (this.formErrors.hasOwnProperty(key)) {
                                this.formErrors[key] = data.errors[key][0];
                            }
                        });
                        return;
                    }
                    console.log(res);
                    showError(
                        "Oops, something went wrong. We could not reset your password"
                    );
                });
        },
    },
};
</script>
