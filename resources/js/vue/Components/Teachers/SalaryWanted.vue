<template>
    <labeled-box label="Salary" @dismiss="dismiss">
        <div class="flex justify-between items-center">
            <p class="text-lg font-bold">
                What salary would you be interested in?
            </p>
        </div>
        <div class="mt-6">
            <div v-for="type in options" class="mr-4 mb-4">
                <radio-input
                    :label="type.description"
                    :value="type.value"
                    name="salary_range"
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
        LabeledBox,
        RadioInput,
    },

    props: ["value"],

    data() {
        return {
            selected: null,
        };
    },

    computed: {
        options() {
            return this.$store.state.placements.salary_ranges;
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
