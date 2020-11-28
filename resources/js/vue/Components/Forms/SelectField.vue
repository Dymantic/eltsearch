<template>
    <div class="" :class="{ 'border-b border-red-400': errorMsg }">
        <label class="">
            <span class="text-sm font-bold">{{ label }}</span>
            <span class="text-xs text-red-400" v-show="errorMsg">{{
                errorMsg
            }}</span>
            <p class="my-1 text-gray-500 text-sm" v-show="helpText">
                {{ helpText }}
            </p>
            <select
                ref="input"
                @input="emitValue"
                :disabled="disabled"
                class="mt-1 w-full block border p-2 bg-transparent"
            >
                <option value :selected="!value"
                    ><span class="text-gray-500">{{ prompt }}</span></option
                >
                <option
                    v-for="(option, val) in options"
                    :selected="value == val"
                    :value="val"
                    >{{ option }}</option
                >
            </select>
        </label>
    </div>
</template>

<script type="text/babel">
export default {
    props: [
        "value",
        "error-msg",
        "label",
        "help-text",
        "options",
        "empty",
        "disabled",
    ],

    computed: {
        prompt() {
            return this.empty || "-- choose an option --";
        },
    },

    mounted() {
        // this.$emit("input", this.$refs.input.value);
    },

    methods: {
        emitValue() {
            this.$emit("input", this.$refs.input.value);
        },
    },
};
</script>
