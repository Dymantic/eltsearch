<template>
    <span>
        <button @click="showModal = true">
            <trash-icon
                class="h-4 text-gray-500 hover:text-red-500"
            ></trash-icon>
        </button>
        <modal :show="showModal" @close="showModal = false">
            <div class="w-screen max-w-md p-6">
                <p class="text-lg font-bold text-red-600">Are you sure?</p>
                <p class="my-6">
                    You are about to delete {{ region.name.en }}, and all its
                    areas. Are you sure there are no jobs or teachers attached
                    to this region?
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
                        @click.native="deleteRegion"
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
import TrashIcon from "../Icons/TrashIcon";
import { showError, showSuccess } from "../../../libs/notifications";
export default {
    components: { Modal, SubmitButton, TrashIcon },

    props: ["region"],

    data() {
        return {
            showModal: false,
            waiting: false,
        };
    },

    methods: {
        deleteRegion() {
            this.waiting = true;

            this.$store
                .dispatch("locations/deleteRegion", this.region.id)
                .then(() => {
                    this.showModal = false;
                    showSuccess("Region deleted.");
                })
                .catch(() => showError("Unable to delete region"));
        },
    },
};
</script>
