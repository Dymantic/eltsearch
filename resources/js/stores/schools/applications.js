import {
    fetchSchoolApplications,
    showInterestInApplicant,
} from "../../api/schools/applications";

export default {
    namespaced: true,

    state: {
        all: [],
    },

    getters: {
        byId: (state) => (id) =>
            state.all.find((app) => app.id === parseInt(id)),
    },

    mutations: {
        setAllApplications(state, applications) {
            state.all = applications;
        },
    },

    actions: {
        fetchApplications({ state, dispatch, rootState }, school_id) {
            if (!rootState.schoolprofile.current_school) {
                return Promise.reject(() => "No school profile set");
            }

            if (state.all.length) {
                return Promise.resolve();
            }

            return dispatch("refreshApplications");
        },

        refreshApplications({ commit, rootState }) {
            if (!rootState.schoolprofile.current_school) {
                return Promise.reject(() => "No school profile set");
            }

            return fetchSchoolApplications(
                rootState.schoolprofile.current_school.id
            ).then((applications) =>
                commit("setAllApplications", applications)
            );
        },

        showInterest({ dispatch }, { application_id, formData }) {
            return showInterestInApplicant(application_id, formData).then(() =>
                dispatch("refreshApplications")
            );
        },
    },
};
