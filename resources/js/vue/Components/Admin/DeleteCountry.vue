<template>
    <span>
        <button class="muted-btn ml-4" @click="showModal = true">
            Delete Country
        </button>
        <modal :show="showModal" @close="showModal = false">
            <div class="w-screen max-w-md p-6">
                <p class="text-lg font-bold text-red-600">Are you sure?</p>
                <p class="my-6">
                    You are about to delete {{ country.name.en }}, and all its
                    regions and areas. Are you sure there are no jobs or
                    teachers attached to this country?
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
                        @click.native="deleteCountry"
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

    props: ["country"],

    data() {
        return {
            showModal: false,
            waiting: false,
        };
    },

    methods: {
        deleteCountry() {
            this.waiting = true;

            this.$store
                .dispatch("locations/deleteCountry", this.country.id)
                .then(() => {
                    this.showModal = false;
                    showSuccess("Country deleted.");
                    this.$router.push("/locations");
                })
                .catch(() => showError("Unable to delete country"));
        },
    },
};
</script>
