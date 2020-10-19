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
            state.profiles = profiles;
            if (profiles && !state.current_school) {
                state.current_school = profiles[0];
            }

            if (profiles && state.current_school) {
                state.current_school = profiles.find(
                    (profile) => profile.id === state.current_school.id
                );
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
        fetchProfiles({ state, dispatch }) {
            if (state.profiles.length) {
                console.log("not fetching");
                return Promise.resolve();
            }

            return dispatch("refreshProfile");
        },

        refreshProfile({ commit }, school_id) {
            return fetchSchoolProfiles()
                .then((profiles) => {
                    commit("setProfiles", profiles);
                    commit("profile/setProfileAvatar", profiles[0].logo.thumb, {
                        root: true,
                    });
                })
                .catch(() => showError("Failed to fetch school info"));
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
