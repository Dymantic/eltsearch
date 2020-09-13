<template>
    <labeled-box label="Weekends" @dismiss="dismiss">
        <p class="font-bold text-lg">Are you happy to work on the weekend?</p>
        <div class="my-4">
            <radio-input
                label="Yes"
                v-model="is_checked"
                :value="true"
                name="weekends"
            ></radio-input>
        </div>
        <div class="my-4">
            <radio-input
                label="No"
                name="weekends"
                v-model="is_checked"
                :value="false"
            ></radio-input>
        </div>
    </labeled-box>
</template>

<script type="text/babel">
import LabeledBox from "../LabeledBox";
import RadioInput from "../Forms/RadioInput";
export default {
    components: {
        LabeledBox,
        RadioInput,
    },

    props: ["value"],

    data() {
        return {
            is_checked: false,
        };
    },

    mounted() {
        this.is_checked = this.value;
    },

    watch: {
        is_checked(to) {
            this.$emit("input", to);
        },
    },

    methods: {
        dismiss() {
            this.is_checked = null;
            this.$emit("dismiss");
        },
    },
};
</script>
