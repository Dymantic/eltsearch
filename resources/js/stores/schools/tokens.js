import { getSchoolTokens } from "../../api/schools/tokens";
import { showError } from "../../libs/notifications";

export default {
    namespaced: true,

    state: {
        valid: [],
    },

    mutations: {
        setValidTokens(state, tokens) {
            state.valid = tokens;
        },
    },

    actions: {
        fetchTokens({ dispatch, state }, school_id) {
            if (state.valid.length) {
                return Promise.resolve();
            }

            return dispatch("refresh", school_id);
        },

        refresh({ commit }, school_id) {
            return getSchoolTokens(school_id)
                .then((tokens) => commit("setValidTokens", tokens))
                .catch(() => showError("Failed to fetch tokens"));
        },
    },
};
