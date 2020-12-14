<template>
    <labeled-box label="Part Time/Full Time" @dismiss="dismiss">
        <div class="flex justify-between items-center">
            <p class="text-lg font-bold">
                Are you looking for a full-time or a part-time job?
            </p>
        </div>
        <div class="mt-6">
            <div v-for="type in options" class="mr-4 mb-4">
                <radio-input
                    :label="type.description"
                    :value="type.value"
                    name="engagement"
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
            selected: "",
        };
    },

    computed: {
        options() {
            return this.$store.state.placements.engagements;
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
            this.selected = "";
            this.$emit("dismiss");
        },
    },
};
</script>
