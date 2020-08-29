import {
    fetchSchoolProfiles,
    updateSchoolProfile,
} from "../../api/schools/school_profile";
import { showError } from "../../libs/notifications";
import { fetchSchoolTypes } from "../../api/schools/school_types";

export default {
    namespaced: true,

    state: {
        profiles: [],
        current_school: null,
        school_types: [],
    },

    mutations: {
        setProfiles(state, profiles) {
            state.profile = profiles;
            if (profiles && !state.current_school) {
                state.current_school = profiles[0];
            }
        },

        setSchoolTypes(state, types) {
            state.school_types = types;
        },
    },

    getters: {
        profileById: (state) => (id) =>
            state.profiles.find((profile) => profile.id === parseInt(id)),
    },

    actions: {
        fetchProfiles({ commit }) {
            return fetchSchoolProfiles().then((profiles) => {
                commit("setProfiles", profiles);
            });
        },

        refreshProfile({ dispatch }, school_id) {
            dispatch("fetchProfiles").catch(() =>
                showError("Failed to fetch profile info")
            );
        },

        updateProfile({ dispatch }, { school_id, formData }) {
            return updateSchoolProfile(school_id, formData).then(() =>
                dispatch("refreshProfile", school_id)
            );
        },

        fetchSchoolTypes({ commit }) {
            return fetchSchoolTypes("zh").then((types) =>
                commit("setSchoolTypes", types)
            );
        },
    },
};
