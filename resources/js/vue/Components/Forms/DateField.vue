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
            <date-picker
                input-class="border p-2 w-full block max-w-xs"
                :inline="inline"
                @input="emit"
                v-model="value"
            ></date-picker>
        </label>
    </div>
</template>

<script type="text/babel">
import DatePicker from "vuejs-datepicker";
// import {toStandardDateFormat} from "../../"
export default {
    components: {
        DatePicker,
    },

    props: [
        "value",
        "error-msg",
        "input-name",
        "label",
        "type",
        "help-text",
        "inline",
    ],

    computed: {
        inputType() {
            return this.type || "text";
        },
    },

    methods: {
        emit(date) {
            this.$emit("input", toStandardDateString(date));
        },
    },
};
</script>
