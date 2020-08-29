<template>
    <div class="" :class="{ 'border-b border-red-400': errorMsg }">
        <label>
            <span class="text-sm font-bold">{{ label }}</span>
            <span class="text-xs text-red-400" v-show="errorMsg">{{
                errorMsg
            }}</span>
            <p class="my-1 text-gray-500 text-sm" v-show="helpText">
                {{ helpText }}
            </p>
            <input
                ref="input"
                type="number"
                :step="step"
                :min="min"
                :max="max"
                :value="value"
                @input="emit"
                class="mt-1 w-full block border p-2"
            />
        </label>
    </div>
</template>

<script type="text/babel">
export default {
    props: {
        value: {},
        "error-msg": {
            type: String,
        },
        label: {
            type: String,
        },
        "help-text": {
            type: String,
        },
        min: {
            type: Number,
            default: 0,
        },
        max: {
            type: Number,
            default: 9999999999999,
        },
        step: {
            type: Number,
            default: 1,
        },
    },

    methods: {
        emit() {
            this.$emit("input", this.$refs.input.value);
        },
    },
};
</script>
