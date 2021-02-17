<template>
    <labeled-box label="Location" @dismiss="$emit('dismiss')">
        <div class="">
            <p class="text-lg font-bold">Where would you like to work?</p>
        </div>
        <div class="my-6">
            <div
                v-for="region in current_regions"
                :key="region.region_id"
                class="border border-gray-300 px-4 py-2 flex justify-between mb-2"
            >
                <p class="text-sm">{{ region.fullname }}</p>
                <button @click="removeRegion(region.region_id)">
                    <trash-icon
                        class="text-red-600 hover:text-red-500 h-4"
                    ></trash-icon>
                </button>
            </div>
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
            <p class="text-gray-600 my-6" v-show="current_areas.length === 0">
                Select the location where you would like to work. We will alert
                you of any new posts from that location.
            </p>
            <div class="mt-6">
                <choose-location
                    :select-region="true"
                    @chosen="addArea"
                    mode="text"
                    :label="
                        current_areas.length === 0
                            ? 'Add location'
                            : 'Add another location'
                    "
                    heading="Where would you like to work?"
                ></choose-location>
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
            return this.value.areas.map((area_id) =>
                this.$store.getters["locations/area_info"](area_id)
            );
        },

        current_regions() {
            return this.value.regions.map((region_id) =>
                this.$store.getters["locations/region_info"](region_id)
            );
        },
    },

    methods: {
        addArea({ id, is_region }) {
            if (is_region) {
                return this.$emit("input", {
                    areas: this.value.areas,
                    regions: [id, ...this.value.regions],
                });
            }

            this.$emit("input", {
                areas: [id, ...this.value.areas],
                regions: this.value.regions,
            });
        },

        removeArea(area_id) {
            this.$emit("input", {
                areas: this.value.areas.filter(
                    (id) => parseInt(id) !== parseInt(area_id)
                ),
                regions: this.value.regions,
            });
        },
        removeRegion(region_id) {
            this.$emit("input", {
                areas: this.value.areas,
                regions: this.value.regions.filter(
                    (id) => parseInt(id) !== parseInt(region_id)
                ),
            });
        },
    },
};
</script>
