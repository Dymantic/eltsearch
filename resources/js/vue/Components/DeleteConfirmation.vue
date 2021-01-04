<template>
    <span>
        <submit-button
            role="button"
            mode="textual"
            :waiting="disabled"
            @click.native="showModal = true"
        >
            <slot></slot>
        </submit-button>
        <modal :show="showModal" @close="showModal = false">
            <div class="p-6 max-w-md w-screen">
                <p class="font-bold text-lg">Are you very sure?</p>
                <p class="my-6">{{ message_body }}</p>
                <div class="flex justify-end mt-6">
                    <button class="btn mr-4" @click="showModal = false">
                        Cancel
                    </button>
                    <button
                        class="btn"
                        :class="button_class"
                        @click="$emit('confirmed') && (showModal = false)"
                    >
                        {{ button_text }}
                    </button>
                </div>
            </div>
        </modal>
    </span>
</template>

<script type="text/babel">
import Modal from "@dymantic/modal";
import SubmitButton from "./Forms/SubmitButton";

export default {
    components: {
        SubmitButton,
        Modal,
    },

    props: ["disabled", "item", "mode", "message", "btn-text"],

    data() {
        return {
            showModal: false,
        };
    },

    computed: {
        message_body() {
            return this.message
                ? this.message
                : `You are about to delete ${this.item}. This may be
                    irreversible.`;
        },

        button_text() {
            return this.btnText || "Yes, delete it!";
        },

        button_class() {
            return this.mode === "primary" ? "btn-primary" : "btn-danger";
        },
    },
};
</script>
