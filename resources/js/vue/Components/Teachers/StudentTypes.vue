<template>
    <labeled-box label="students" @dismiss="$emit('dismiss')">
        <div class="flex justify-between items-center">
            <p class="text-lg font-bold">
                What age of student would you like to teach?
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
            return this.$store.state.placements.student_ages;
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
};
</script>
