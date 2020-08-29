<template>
    <div>
        <div class="w-screen max-w-lg p-6">
            <div>
                <p class="font-bold mb-6">Where would you like to work?</p>
                <div>
                    <select-field
                        class="my-6"
                        v-model="country"
                        :options="countries"
                        error-msg=""
                        label="Country"
                        empty="-- Choose a country --"
                    ></select-field>

                    <select-field
                        class="my-6"
                        v-model="region"
                        :options="regions"
                        error-msg=""
                        label="Region"
                        empty="-- Choose a region --"
                        :disabled="!regions"
                    ></select-field>

                    <select-field
                        class="my-6"
                        v-model="area"
                        :options="areas"
                        error-msg=""
                        label="Area"
                        empty="-- Choose an area --"
                        :disabled="!areas"
                    ></select-field>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { showError } from "../../../libs/notifications";

export default {
    data() {
        return {
            country: null,
            region: null,
            area: null,
        };
    },

    computed: {
        locations() {
            return this.$store.state.locations.all_locations;
        },

        from_country() {
            return this.locations.find(
                (location) => location.id === parseInt(this.country)
            );
        },

        from_region() {
            if (!this.from_country) {
                return null;
            }

            return this.from_country.regions.find(
                (region) => region.id === parseInt(this.region)
            );
        },

        countries() {
            return this.locations.reduce((options, location) => {
                options[location.id] = location.name;
                return options;
            }, {});
        },

        regions() {
            if (!this.from_country) {
                return {};
            }

            return this.from_country.regions.reduce((options, region) => {
                options[region.id] = region.name;
                return options;
            }, {});
        },

        areas() {
            if (!this.from_region) {
                return {};
            }

            return this.from_region.areas.reduce((options, area) => {
                options[area.id] = area.name;
                return options;
            }, {});
        },
    },

    watch: {
        country(to, from) {
            if (to !== from) {
                this.region = null;
                this.area = null;
            }
        },

        region(to, from) {
            if (to !== from) {
                this.area = null;
            }
        },
    },

    created() {
        this.$store
            .dispatch("locations/fetchLocations", "zh")
            .catch(() => showError("Failed to fetch locations"));
    },

    methods: {},
};
</script>
