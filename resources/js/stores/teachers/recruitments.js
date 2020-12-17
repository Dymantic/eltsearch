import {
    dismissTeacherRecruitmentAttempt,
    fetchTeacherRecruitmentAttempts,
} from "../../api/teachers/recruitments";
import { showError } from "../../libs/notifications";

export default {
    namespaced: true,

    state: {
        all: [],
    },

    getters: {
        byId: (state) => (id) => state.all.find((a) => a.id === parseInt(id)),
    },

    mutations: {
        setAll(state, attempts) {
            state.all = attempts;
        },
    },

    actions: {
        fetch({ state, dispatch }) {
            if (state.all.length) {
                return Promise.resolve();
            }
            return dispatch("refresh");
        },

        refresh({ commit }) {
            return fetchTeacherRecruitmentAttempts()
                .then((attempts) => commit("setAll", attempts))
                .catch(() => showError("Failed to fetch school messages"));
        },

        dismiss({ dispatch }, recruitment_attempt_id) {
            return dismissTeacherRecruitmentAttempt(
                recruitment_attempt_id
            ).then(() => dispatch("refresh"));
        },
    },
};
