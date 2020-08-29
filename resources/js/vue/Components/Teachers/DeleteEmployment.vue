<template>
    <span>
        <button @click="showModal = true">Delete</button>
        <modal :show="showModal" @close="showModal = false">
            <div class="p-6 w-screen max-w-md">
                <p class="text-lg font-bold text-red-500">Are you sure?</p>
                <p class="my-4">
                    You are about to delete your employment history with
                    {{ employer }}. Do you want to proceed?
                </p>
                <div class="flex justify-end mt-6">
                    <button @click="showModal = false" class="mr-4">
                        Cancel
                    </button>
                    <submit-button
                        @click.native="submit"
                        mode="danger"
                        role="button"
                        :waiting="waiting"
                        >Yes, delete it!</submit-button
                    >
                </div>
            </div>
        </modal>
    </span>
</template>

<script type="text/babel">
import SubmitButton from "../Forms/SubmitButton";
import Modal from "@dymantic/modal";
import { showError, showSuccess } from "../../../libs/notifications";
export default {
    components: {
        SubmitButton,
        Modal,
    },

    props: ["employer", "employment-id"],

    data() {
        return {
            waiting: false,
            showModal: false,
        };
    },

    methods: {
        submit() {
            this.waiting = true;
            this.$store
                .dispatch("profile/deleteEmployment", this.employmentId)
                .then(() => {
                    showSuccess("Employment entry deleted.");
                    this.$router.push("/previous-employments");
                })
                .catch(() => showError("Failed to delete employment info."))
                .then(() => {
                    this.showModal = false;
                    this.waiting = false;
                });
        },
    },
};
</script>
