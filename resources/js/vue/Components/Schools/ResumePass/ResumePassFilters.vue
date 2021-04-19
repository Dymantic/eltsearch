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
            <div class="max-w-3xl w-80 p-6 rounded-lg">
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
                        :empty="trns('resume_pass.filters_experience.any')"
                    ></select-field>

                    <select-field
                        class="my-3 pb-3 border-b border-gray-200"
                        :label="`${trns('resume_pass.nationality')}:`"
                        :options="nations"
                        v-model="filters.nation_id"
                        :empty="trns('resume_pass.any_nationality')"
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
            const lang = this.$store.state.profile.preferred_lang;
            return this.$store.getters["nations/forSelect"](lang);
        },

        experience_options() {
            return [
                {
                    value: 1,
                    text: this.trns("resume_pass.filters_experience.one"),
                },
                {
                    value: 3,
                    text: this.trns("resume_pass.filters_experience.three"),
                },
                {
                    value: 5,
                    text: this.trns("resume_pass.filters_experience.five"),
                },
                {
                    value: 7,
                    text: this.trns("resume_pass.filters_experience.ten"),
                },
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
