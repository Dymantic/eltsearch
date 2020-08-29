<template>
    <div v-if="country">
        <div class="flex justify-between items-center mb-12">
            <p class="">
                <span class="text-lg font-bold">{{ country.name.en }}</span>
                <span class="ml-3 text-gray-600">{{ country.name.zh }}</span>
            </p>
            <div class="flex justify-end items-center">
                <add-country :country="country"></add-country>
                <delete-country :country="country"></delete-country>
            </div>
        </div>
        <div class="flex flex-col lg:flex-row">
            <div class="lg:w-64 flex-shrink-0 lg:mr-6 mb-8">
                <div
                    class="flex justify-between items-center border-b border-gray-300 mb-4"
                >
                    <p class="uppercase text-gray-600">Regions</p>
                    <add-region class="" :country="country"></add-region>
                </div>
                <div>
                    <div
                        v-for="region in country.regions"
                        class="mb-3 border-b border-gray-200 flex justify-between items-center"
                    >
                        <button
                            @click="setRegion(region.id)"
                            class="focus:outline-none"
                            :class="{
                                'font-bold text-sky-blue':
                                    show_region && region.id === show_region,
                            }"
                        >
                            <span>{{ region.name.en }}</span>
                            <span class="text-sm text-gray-600 mx-2">{{
                                region.name.zh
                            }}</span>
                        </button>
                        <div>
                            <add-region :region="region"></add-region>
                            <delete-region :region="region"></delete-region>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lg:px-6 flex-1">
                <div
                    class="flex justify-between items-center border-b border-gray-300 mb-4"
                >
                    <p class="uppercase">Areas</p>
                    <add-area
                        v-if="currentRegion"
                        :region="currentRegion"
                    ></add-area>
                </div>
                <div v-if="currentRegion">
                    <div
                        v-for="area in currentRegion.areas"
                        class="shadow mb-4 p-2 relative"
                    >
                        <div>
                            <p class="font-bold">{{ area.name.en }}</p>
                            <p class="mt-2 text0gray-600 text-sm">
                                {{ area.name.zh }}
                            </p>
                        </div>
                        <div class="absolute right-0 bottom-0 m-2">
                            <add-area
                                :region="currentRegion"
                                :area="area"
                            ></add-area>
                            <delete-area :area="area"></delete-area>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import DeleteCountry from "./DeleteCountry";
import AddCountry from "./AddCountry";
import AddRegion from "./AddRegion";
import AddArea from "./AddArea";
import DeleteRegion from "./DeleteRegion";
import DeleteArea from "./DeleteArea";
import { showError } from "../../../libs/notifications";

export default {
    components: {
        DeleteCountry,
        AddCountry,
        AddRegion,
        AddArea,
        DeleteRegion,
        DeleteArea,
    },

    data() {
        return {
            show_region: null,
        };
    },

    computed: {
        country() {
            return this.$store.getters["locations/countryById"](
                this.$route.params.country
            );
        },

        currentRegion() {
            return this.country.regions.find(
                (reg) => reg.id === this.show_region
            );
        },
    },

    mounted() {
        this.$store
            .dispatch("locations/fetchCountries")
            .catch(() => showError("Unable to fetch locations"));
    },

    methods: {
        setRegion(region_id) {
            this.show_region = region_id;
        },
    },
};
</script>
