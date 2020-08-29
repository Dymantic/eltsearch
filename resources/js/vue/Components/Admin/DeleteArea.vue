<template>
    <span>
        <button @click="showModal = true">delete</button>
        <modal :show="showModal" @close="showModal = false">
            <div class="w-screen max-w-md p-6">
                <p class="text-lg font-bold text-red-600">Are you sure?</p>
                <p class="my-6">
                    You are about to delete {{ area.name.en }}. Are you sure
                    there are no jobs or teachers attached to this country?
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
                        class="mr-4"
                        @click.native="deleteArea"
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

    props: ["area"],

    data() {
        return {
            showModal: false,
            waiting: false,
        };
    },

    methods: {
        deleteArea() {
            this.waiting = true;

            this.$store
                .dispatch("locations/deleteArea", this.area.id)
                .then(() => {
                    this.showModal = false;
                    showSuccess("Area deleted.");
                })
                .catch(() => showError("Unable to delete area"));
        },
    },
};
</script>
