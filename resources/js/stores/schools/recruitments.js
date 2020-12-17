import { attemptToRecruitTeacher } from "../../api/schools/teachers";
import { fetchRecentSchoolRecruitmentAttempts } from "../../api/schools/recruitments";
import { showError } from "../../libs/notifications";

export default {
    namespaced: true,

    state: {
        recent: [],
    },

    getters: {
        forTeacher: (state) => (slug) =>
            state.recent.filter((a) => a.teacher.slug === slug),
    },

    mutations: {
        setRecent(state, recent) {
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

        refresh({ rootState, commit }) {
            return fetchRecentSchoolRecruitmentAttempts(
                rootState.profile.current_school_id
            )
                .then((recent) => commit("setRecent", recent))
                .catch(() =>
                    showError("Unable to check recent messages to teachers.")
                );
        },

        recruitTeacher({ rootState, dispatch }, { teacher_slug, formData }) {
            return attemptToRecruitTeacher(
                rootState.profile.current_school_id,
                teacher_slug,
                formData
            ).then(() => dispatch("refresh"));
        },
    },
};
