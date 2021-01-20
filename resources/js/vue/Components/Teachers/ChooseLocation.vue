<template>
    <span>
        <button type="button" @click="showModal = true" class="text-btn">
            {{ button_text }}
        </button>
        <modal :show="showModal" @close="showModal = false">
            <div class="w-screen max-w-lg p-6">
                <div>
                    <p class="font-bold mb-6">{{ heading }}</p>
                    <select-field
                        class="my-6"
                        v-model="country"
                        :options="countries"
                        error-msg=""
                        :label="trns('choose_location.country')"
                        empty="-- Choose a country --"
                    ></select-field>

                    <select-field
                        class="my-6"
                        v-model="region"
                        :options="regions"
                        error-msg=""
                        :label="trns('choose_location.region')"
                        empty="-- Choose a region --"
                        :disabled="!regions"
                    ></select-field>

                    <select-field
                        class="my-6"
                        v-model="area"
                        :options="areas"
                        error-msg=""
                        :label="trns('choose_location.area')"
                        empty="-- Choose an area --"
                        :disabled="!areas"
                    ></select-field>
                </div>
                <div class="mt-6 flex justify-end">
                    <button
                        type="button"
                        @click="showModal = false"
                        class="mx-4 muted-btn"
                    >
                        {{ trns("choose_location.cancel") }}
                    </button>
                    <button
                        type="button"
                        class="btn btn-primary"
                        @click="chooseArea"
                        :disabled="incomplete"
                    >
                        {{ trns("choose_location.done") }}
                    </button>
                </div>
            </div>
        </modal>
    </span>
</template>

<script type="text/babel">
import Modal from "@dymantic/modal";
import SelectField from "../Forms/SelectField";
export default {
    components: {
        Modal,
        SelectField,
    },

    props: ["label", "heading"],

    data() {
        return {
            showModal: false,
            country: null,
            region: null,
            area: null,
        };
    },

    computed: {
        button_text() {
            return this.label || "Add Location";
        },

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

        incomplete() {
            return !this.country || !this.regions || !this.area;
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

    mounted() {
        this.$store.dispatch("locations/fetchLocations", "en");
    },

    methods: {
        chooseArea() {
            this.$emit("chosen", this.area);
            this.country = null;
            this.region = null;
            this.area = null;
            this.showModal = false;
        },
    },
};
</script>
