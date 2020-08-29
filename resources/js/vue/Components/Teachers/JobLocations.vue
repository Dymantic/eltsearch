<template>
    <labeled-box label="Location" @dismiss="$emit('dismiss')">
        <div class="flex justify-between items-center">
            <p class="text-lg font-bold">Where would you like to work?</p>
            <choose-location @chosen="addArea"></choose-location>
        </div>
        <div class="my-6">
            <div
                v-for="area in current_areas"
                :key="area.area_id"
                class="border border-gray-300 px-4 py-2 flex justify-between mb-2"
            >
                <p class="text-sm">{{ area.fullname }}</p>
                <button @click="removeArea(area.area_id)">
                    <trash-icon
                        class="text-red-600 hover:text-red-500 h-4"
                    ></trash-icon>
                </button>
            </div>
        </div>
    </labeled-box>
</template>

<script type="text/babel">
import LabeledBox from "../LabeledBox";
import ChooseLocation from "./ChooseLocation";
import TrashIcon from "../Icons/TrashIcon";
export default {
    components: {
        LabeledBox,
        ChooseLocation,
        TrashIcon,
    },

    props: ["value"],

    computed: {
        current_areas() {
            return this.value.map((area_id) =>
                this.$store.getters["locations/area_info"](area_id)
            );
        },
    },

    methods: {
        addArea(area_id) {
            this.$emit("input", [...this.value, area_id]);
        },

        removeArea(area_id) {
            this.$emit(
                "input",
                this.value.filter((id) => parseInt(id) !== parseInt(area_id))
            );
        },
    },
};
</script>
