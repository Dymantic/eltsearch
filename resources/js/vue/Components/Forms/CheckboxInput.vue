<template>
    <div class="" :class="{ 'border-b border-red-400': errorMsg }">
        <label class="items-center">
            <p class="my-1 text-gray-500 text-sm" v-show="helpText">
                {{ helpText }}
            </p>
            <div class="flex items-center">
                <input
                    ref="checkbox"
                    type="checkbox"
                    @input="emitValue"
                    class="hidden"
                    :checked="is_checked"
                    :value="value"
                />
                <div
                    class="mr-3 w-4 h-4 rounded-sm border border-sky-blue fake-checkbox flex justify-center items-center"
                >
                    <check-icon class="text-white h-3"></check-icon>
                </div>
                <span class="text-sm">{{ label }}</span>
                <span class="text-xs text-red-400" v-show="errorMsg">{{
                    errorMsg
                }}</span>
            </div>
        </label>
    </div>
</template>

<script type="text/babel">
import CheckIcon from "../Icons/CheckIcon";
export default {
    components: { CheckIcon },
    model: {
        prop: "checked",
        event: "input",
    },

    props: ["checked", "error-msg", "label", "help-text", "value"],

    computed: {
        is_checked() {
            if (Array.isArray(this.checked)) {
                return this.checked.includes(this.value);
            }
            return this.value === this.checked;
        },
    },

    methods: {
        emitValue() {
            const value = this.$refs.checkbox.checked
                ? this.withValue()
                : this.withoutValue();
            this.$emit("input", value);
        },

        withValue() {
            if (!Array.isArray(this.checked)) {
                return true;
            }

            return [...this.checked, this.value];
        },

        withoutValue() {
            if (!Array.isArray(this.checked)) {
                return false;
            }

            return this.checked.filter((item) => item !== this.value);
        },
    },
};
</script>

<style scoped>
input[type="checkbox"]:checked + .fake-checkbox {
    @apply bg-sky-blue border-sky-blue;
}
</style>
