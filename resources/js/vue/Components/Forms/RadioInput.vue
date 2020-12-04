<template>
    <div class="" :class="{ 'border-b border-red-400': errorMsg }">
        <label class="flex items-center">
            <span class="text-sm">{{ label }}</span>
            <span class="text-xs text-red-400" v-show="errorMsg">{{
                errorMsg
            }}</span>
            <input
                ref="radio"
                type="radio"
                :name="name"
                :value="value"
                @input="emitValue"
                class="hidden"
                :checked="checked === value"
            />
            <div
                class="ml-3 w-4 h-4 rounded-full border border-black fake-radio"
            ></div>
            <p class="my-1 text-gray-500 text-sm" v-show="helpText">
                {{ helpText }}
            </p>
        </label>
    </div>
</template>

<script type="text/babel">
export default {
    model: {
        prop: "checked",
        event: "input",
    },

    props: ["checked", "error-msg", "name", "label", "help-text", "value"],

    methods: {
        emitValue() {
            this.$emit("input", this.value);
        },
    },
};
</script>

<style scoped>
input[type="radio"]:checked + .fake-radio {
    @apply bg-sky-blue;
}
</style>
