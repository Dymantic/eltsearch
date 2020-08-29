<template>
    <div>
        <div class="flex justify-between items-center">
            <p class="text-lg font-bold">ELTSearch Locations</p>
            <div class="flex justify-end items-center">
                <add-country></add-country>
            </div>
        </div>
        <div>
            <div
                v-for="country in locations"
                :key="country.id"
                class="my-6 shadow p-4"
            >
                <p class="mb-4">
                    <router-link
                        :to="`/countries/${country.id}`"
                        class="font-bold hover:text-sky-blue"
                        >{{ country.name.en }}</router-link
                    >
                </p>
                <div class="flex flex-wrap">
                    <p class="text-gray-600 mr-8">
                        {{ country.regions.length }} Regions
                    </p>
                    <p class="text-gray-600">{{ countAreas(country) }} Areas</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import AddCountry from "./AddCountry";
import { showError } from "../../../libs/notifications";
export default {
    components: { AddCountry },

    computed: {
        locations() {
            return this.$store.state.locations.countries;
        },
    },

    mounted() {
        this.$store
            .dispatch("locations/fetchCountries")
            .catch(() => showError("Unable to fetch locations."));
    },

    methods: {
        countAreas(country) {
            return country.regions.reduce(
                (tally, region) => tally + region.areas.length,
                0
            );
        },
    },
};
</script>
