<template>
    <div>
        <div v-for="type in options" class="mr-4 mb-4">
            <checkbox-input
                :label="type.name"
                :value="type.id"
                v-model="selected"
            ></checkbox-input>
        </div>
    </div>
</template>

<script type="text/babel">
import CheckboxInput from "../Forms/CheckboxInput";
import { showError } from "../../../libs/notifications";
export default {
    components: {
        CheckboxInput,
    },

    props: ["value", "options"],

    data() {
        return {
            selected: this.value,
        };
    },

    watch: {
        selected() {
            this.$emit("input", this.selected);
        },
    },
};
</script>
