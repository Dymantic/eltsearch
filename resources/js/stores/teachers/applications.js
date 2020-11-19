import {
    applyForJob,
    fetchTeacherApplications,
} from "../../api/teachers/applications";
import { showError } from "../../libs/notifications";

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
        setApplications(state, applications) {
            state.all = applications;
        },
    },

    actions: {
        fetchApplications({ dispatch, state }) {
            if (state.all.length) {
                return Promise.resolve();
            }

            return dispatch("refresh");
        },

        refresh({ commit }) {
            return fetchTeacherApplications()
                .then((applications) => commit("setApplications", applications))
                .catch(() => showError("Failed to fetch your applications"));
        },

        apply({ dispatch }, formData) {
            return applyForJob(formData).then(() => {
                dispatch("refresh");
                dispatch("matches/refresh", null, { root: true });
            });
        },
    },
};
