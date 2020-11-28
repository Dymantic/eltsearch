<template>
    <div>
        <page-header title="ELT Search Locations">
            <add-country></add-country>
        </page-header>

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
import PageHeader from "../PageHeader";
export default {
    components: { PageHeader, AddCountry },

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
