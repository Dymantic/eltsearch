<template>
    <div class="" :class="{ 'border-b border-red-400': errorMsg }">
        <label class="">
            <span class="text-sm font-semibold">{{ label }}</span>
            <span class="text-xs text-red-400" v-show="errorMsg">{{
                errorMsg
            }}</span>
            <p class="my-1 text-gray-600 text-sm" v-show="helpText">
                {{ helpText }}
            </p>
            <textarea
                ref="input"
                @input="emit"
                @paste="checkPaste"
                @keydown="checkLength"
                class="mt-1 w-full block border p-2"
                :class="height"
                >{{ value }}</textarea
            >
        </label>
        <div class="flex justify-end" v-if="this.wordLimit">
            <colour-label
                class="mt-1"
                :colour="wcColour"
                :text="wcText"
            ></colour-label>
        </div>
    </div>
</template>

<script type="text/babel">
import wordsCount from "words-count";
import ColourLabel from "../ColourLabel";
import { showError } from "../../../libs/notifications";
export default {
    components: { ColourLabel },
    props: [
        "value",
        "error-msg",
        "input-name",
        "label",
        "type",
        "help-text",
        "height",
        "word-limit",
    ],

    computed: {
        inputType() {
            return this.type || "text";
        },

        wc() {
            return wordsCount(this.value);
        },

        wcText() {
            return `Words: ${this.wc} (Max: ${this.wordLimit})`;
        },

        wcColour() {
            const used = this.wc / this.wordLimit;
            if (used >= 0.9) {
                return "red";
            }

            if (used >= 0.75) {
                return "orange";
            }

            return "green";
        },
    },

    methods: {
        emit() {
            this.$emit("input", this.$refs.input.value);
        },

        checkLength(ev) {
            if (!this.wordLimit) {
                return;
            }

            if (this.wc >= this.wordLimit && ev.key !== "Backspace") {
                ev.preventDefault();
            }
        },

        checkPaste(ev) {
            const paste = (ev.clipboardData || window.clipboardData).getData(
                "text"
            );
            if (this.wc + wordsCount(paste) >= this.wordLimit) {
                showError(`Cannot add text over ${this.wordLimit} words`);
                ev.preventDefault();
            }
        },
    },
};
</script>
