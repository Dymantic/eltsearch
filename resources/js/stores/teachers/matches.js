import {
    dismissJobMatch,
    getTeacherJobMatches,
} from "../../api/teachers/matches";
import { showError } from "../../libs/notifications";

export default {
    namespaced: true,

    state: {
        all: [],
    },

    getters: {
        byId: (state) => (id) =>
            state.all.find((match) => match.id === parseInt(id)),
    },

    mutations: {
        setMatches(state, matches) {
            state.all = matches;
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
            return getTeacherJobMatches()
                .then((matches) => commit("setMatches", matches))
                .catch(() => showError("Failed to fetch your job matches"));
        },

        dismiss({ dispatch }, match_id) {
            return dismissJobMatch(match_id).then(() => dispatch("refresh"));
        },
    },
};
