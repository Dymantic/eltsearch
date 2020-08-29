<template>
    <span>
        <button @click="showModal = true" class="muted-btn">Delete</button>
        <modal :show="showModal" @close="showModal = false">
            <div class="w-screen max-w-md p-6">
                <p class="text-lg font-bold text-red-600">Are you sure?</p>
                <p class="my-6">
                    You are about to delete {{ type.name.en }}. It will no
                    longer be an option for job posts.
                </p>
                <div class="mt-6 flex justify-end">
                    <button
                        type="button"
                        class="mr-4"
                        @click="showModal = false"
                    >
                        Cancel
                    </button>
                    <submit-button
                        role="button"
                        mode="danger"
                        class="mr-4"
                        @click.native="deleteType"
                        >Yes, delete it.</submit-button
                    >
                </div>
            </div>
        </modal>
    </span>
</template>

<script type="text/babel">
import Modal from "@dymantic/modal";
import SubmitButton from "../Forms/SubmitButton";
import { showError, showSuccess } from "../../../libs/notifications";
export default {
    components: { Modal, SubmitButton },

    props: ["type"],

    data() {
        return {
            showModal: false,
            waiting: false,
        };
    },

    methods: {
        deleteType() {
            this.waiting = true;

            this.$store
                .dispatch("schooltypes/deleteType", this.type.id)
                .then(() => {
                    this.showModal = false;
                    showSuccess("School type deleted.");
                })
                .catch(() => showError("Unable to delete school type"));
        },
    },
};
</script>
