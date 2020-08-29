import {
    fetchJobSearchOptions,
    saveJobSearch,
} from "../../api/teachers/job_searches";

export default {
    namespaced: true,

    state: {
        student_ages: [],
        benefits: [],
        contract_lengths: [],
        hours: [],
        salary_ranges: [],
        engagements: [],
        schedule_times: [],
    },

    mutations: {
        setAllowedOptions(state, options) {
            state.student_ages = options.student_ages;
            state.benefits = options.benefits;
            state.contract_lengths = options.contract_lengths;
            state.hours = options.hours;
            state.salary_ranges = options.salary_ranges;
            state.engagements = options.engagements;
            state.schedule_times = options.schedule_times;
        },
    },

    actions: {
        fetchOptions({ commit }) {
            fetchJobSearchOptions().then((options) =>
                commit("setAllowedOptions", options)
            );
        },

        updateJobSearch({ dispatch }, formData) {
            return saveJobSearch(formData);
        },
    },
};
