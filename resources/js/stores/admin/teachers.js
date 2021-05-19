import {
    fetchTeacherById,
    fetchTeacherOverview,
} from "../../api/admin/teachers";
import { showError } from "../../libs/notifications";

export default {
    namespaced: true,

    state: {
        total_count: 0,
        signed_up_last_month: 0,
        recent: [],
        complete_profiles: 0,
    },

    mutations: {
        setOverview(
            state,
            { total_count, signed_up_last_month, recent, complete_profiles }
        ) {
            state.total_count = total_count;
            state.signed_up_last_month = signed_up_last_month;
            state.recent = recent;
            state.complete_profiles = complete_profiles;
        },
    },

    actions: {
        fetch({ state, dispatch }) {
            if (state.recent.length) {
                return Promise.resolve();
            }

            return dispatch("refresh");
        },

        refresh({ commit }) {
            return fetchTeacherOverview()
                .then((overview) => commit("setOverview", overview))
                .catch(() => showError("Unable to fetch teacher info"));
        },

        fetchById({ state }, { teacher_id, force = false }) {
            const from_recent = state.recent.find(
                (t) => t.id === parseInt(teacher_id)
            );
            if (from_recent && !force) {
                return Promise.resolve(from_recent);
            }

            return fetchTeacherById(teacher_id);
        },
    },
};
