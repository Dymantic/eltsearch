<template>
    <labeled-box label="Schedule" @dismiss="dismiss">
        <div class="flex justify-between items-center">
            <p class="text-lg font-bold">
                What times of day are you okay to work in?
            </p>
        </div>
        <div class="mt-6">
            <div v-for="type in options" class="mr-4 mb-4">
                <checkbox-input
                    :label="type.description"
                    :value="type.value"
                    v-model="selected"
                ></checkbox-input>
            </div>
        </div>
    </labeled-box>
</template>

<script type="text/babel">
import LabeledBox from "../LabeledBox";
import CheckboxInput from "../Forms/CheckboxInput";
export default {
    components: {
        LabeledBox,
        CheckboxInput,
    },

    props: ["value"],

    data() {
        return {
            selected: [],
        };
    },

    computed: {
        options() {
            return this.$store.state.placements.schedule_times;
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
            this.selected = [];
            this.$emit("dismiss");
        },
    },
};
</script>
