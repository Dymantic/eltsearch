import { getSchoolById, getSchoolsOverview } from "../../api/admin/schools";
import { showError } from "../../libs/notifications";

export default {
    namespaced: true,

    state: {
        recent: [],
        total_count: 0,
        signed_up_last_month: 0,
    },

    mutations: {
        setOverview(state, { recent, signed_up_last_month, total_count }) {
            state.recent = recent;
            state.signed_up_last_month = signed_up_last_month;
            state.total_count = total_count;
        },
    },

    actions: {
        fetch({ state, dispatch }) {
            if (state.recent.length) {
                return Promise.resolve();
            }
            dispatch("refresh");
        },

        refresh({ commit }) {
            return getSchoolsOverview()
                .then((overview) => commit("setOverview", overview))
                .catch(() => showError("Failed to fetch schools info"));
        },

        getById({ state }, { school_id, force = false }) {
            const from_recent = state.recent.find(
                (s) => s.id === parseInt(school_id)
            );

            if (from_recent && !force) {
                return Promise.resolve(from_recent);
            }

            return getSchoolById(school_id);
        },
    },
};
