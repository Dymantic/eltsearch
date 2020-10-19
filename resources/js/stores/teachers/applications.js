import { fetchTeacherApplications } from "../../api/teachers/applications";

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
        fetchApplications({ commit }) {
            return fetchTeacherApplications().then((applications) =>
                commit("setApplications", applications)
            );
        },
    },
};
