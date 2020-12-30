<template>
    <div class="my-12 flex justify-between max-w-3xl">
        <p class="type-b1">{{ trns("resume_pass.use_filters") }}</p>
        <button
            @click="showFilters = true"
            class="flex items-center leading-none"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                class="fill-current h-5 text-sky-blue mr-2"
            >
                <path
                    d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011 1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z"
                />
            </svg>
            <span>{{ trns("resume_pass.filters") }}</span>
        </button>
        <modal :show="showFilters" @close="showFilters = false">
            <div class="max-w-3xl p-6 rounded-lg">
                <p class="type-h3 mb-4">{{ trns("resume_pass.filters") }}</p>
                <div class="">
                    <p class="text-sm">{{ trns("resume_pass.location") }}:</p>
                    <checkbox-input
                        :label="trns('resume_pass.only_in_area')"
                        v-model="filters.area"
                        :value="true"
                        class="my-3 pb-3 border-b border-gray-200"
                    ></checkbox-input>

                    <select-field
                        class="my-3 pb-3 border-b border-gray-200"
                        :label="`${trns('resume_pass.experience_level')}:`"
                        :options="experience_options"
                        v-model="filters.experience"
                        empty="Any amount of experience"
                    ></select-field>

                    <select-field
                        class="my-3 pb-3 border-b border-gray-200"
                        :label="`${trns('resume_pass.nationality')}:`"
                        :options="nations"
                        v-model="filters.nation_id"
                        empty="Any nationality"
                    ></select-field>

                    <div class="flex items-center justify-end mt-6">
                        <button
                            type="button"
                            @click="clearFilters"
                            class="btn mr-4"
                        >
                            {{ trns("resume_pass.filters_clear") }}
                        </button>

                        <button
                            type="button"
                            @click="applyFilters"
                            class="btn btn-primary"
                        >
                            {{ trns("resume_pass.filters_apply") }}
                        </button>
                    </div>
                </div>
            </div>
        </modal>
    </div>
</template>

<script type="text/babel">
import CheckboxInput from "../../Forms/CheckboxInput";
import SelectField from "../../Forms/SelectField";
import Modal from "@dymantic/modal";
export default {
    components: { CheckboxInput, SelectField, Modal },

    data() {
        return {
            showFilters: false,
            filters: {
                area: false,
                nation_id: null,
                experience: null,
            },
        };
    },

    computed: {
        nations() {
            return this.$store.getters["nations/forSelect"];
        },

        experience_options() {
            return [
                { value: 1, text: "One ot more years" },
                { value: 3, text: "Three or more years" },
                { value: 5, text: "Five or more years" },
                { value: 7, text: "Ten or more years" },
            ];
        },
    },

    mounted() {
        this.$store.dispatch("nations/fetch");
    },

    methods: {
        applyFilters() {
            this.$emit("applied", this.filters);
            this.showFilters = false;
        },

        clearFilters() {
            this.filters = {
                area: false,
                nation_id: null,
                experience: null,
            };
            this.$emit("applied", this.filters);
            this.showFilters = false;
        },
    },
};
</script>
