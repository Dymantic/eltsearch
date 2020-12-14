<template>
    <div class="" :class="{ 'border-b border-red-400': errorMsg }">
        <label class="flex items-center">
            <p class="my-1 text-gray-500 text-sm" v-show="helpText">
                {{ helpText }}
            </p>
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
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    class="fill-current text-white h-3"
                >
                    <path
                        fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                        clip-rule="evenodd"
                    />
                </svg>
            </div>
            <span class="text-sm">{{ label }}</span>
            <span class="text-xs text-red-400" v-show="errorMsg">{{
                errorMsg
            }}</span>
        </label>
    </div>
</template>

<script type="text/babel">
export default {
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
                return true;
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
