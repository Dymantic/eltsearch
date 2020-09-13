<template>
    <labeled-box label="Hours per Week" @dismiss="dismiss">
        <div class="flex justify-between items-center">
            <p class="text-lg font-bold">
                How many hours are you happy working per week?
            </p>
        </div>
        <div class="mt-6">
            <div v-for="type in options" class="mr-4 mb-4">
                <radio-input
                    :label="type.description"
                    :value="type.value"
                    name="weekly_hours"
                    v-model="selected"
                ></radio-input>
            </div>
        </div>
    </labeled-box>
</template>

<script type="text/babel">
import LabeledBox from "../LabeledBox";
import RadioInput from "../Forms/RadioInput";
export default {
    components: {
        RadioInput,
        LabeledBox,
    },

    props: ["value"],

    data() {
        return {
            selected: null,
        };
    },

    computed: {
        options() {
            return this.$store.state.placements.hours;
        },
    },

    mounted() {
        this.selected = this.value;
    },

    watch: {
        selected() {
            this.$emit("input", this.selected);
        },
    },

    methods: {
        dismiss() {
            this.selected = null;
            this.$emit("dismiss");
        },
    },
};
</script>
