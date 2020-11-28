import { getJobPostById, getJobPostsOverview } from "../../api/admin/job_posts";
import { showError } from "../../libs/notifications";

export default {
    namespaced: true,

    state: {
        total_live: 0,
        posted_in_last_week: 0,
        recent: [],
    },

    getters: {
        byId: (state) => (id) =>
            state.recent.find((p) => p.id === parseInt(id)),
    },

    mutations: {
        setOverview(state, { total_live, posted_in_last_week, recent }) {
            state.total_live = total_live;
            state.posted_in_last_week = posted_in_last_week;
            state.recent = recent;
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
            return getJobPostsOverview()
                .then((overview) => commit("setOverview", overview))
                .catch(() => showError("Failed to fetch job post info"));
        },

        getById({ getters }, job_post_id) {
            const from_recent = getters.byId(job_post_id);

            if (from_recent) {
                Promise.resolve(from_recent);
            }

            return getJobPostById(job_post_id);
        },
    },
};
