<template>
    <div class="" :class="{ 'border-b border-red-400': errorMsg }">
        <label>
            <span class="type-b2">{{ label }}</span>
            <span class="text-xs text-red-400" v-show="errorMsg">{{
                errorMsg
            }}</span>
            <p class="my-1 text-gray-500 text-sm" v-show="helpText">
                {{ helpText }}
            </p>
            <input
                ref="input"
                :type="inputType"
                :value="value"
                @input="emit"
                class="mt-1 w-full block border p-2 type-b1"
            />
        </label>
    </div>
</template>

<script type="text/babel">
export default {
    props: ["value", "error-msg", "input-name", "label", "type", "help-text"],

    computed: {
        inputType() {
            return this.type || "text";
        },
    },

    methods: {
        emit() {
            this.$emit("input", this.$refs.input.value);
        },
    },
};
</script>
