import {
    createTeacherPreviousEmployment,
    deleteTeacherPreviousEmployment,
    fetchTeacherEducationInfo,
    fetchTeacherGeneralInfo,
    fetchTeacherPreviousEmploymentInfo,
    updateTeacherEducationInfo,
    updateTeacherLocation,
    updateTeacherPersonalInfo,
    updateTeacherPreviousEmployment,
} from "../../api/teachers/profile";
import { showError } from "../../libs/notifications";
import { refreshProfileInfo } from "../../api/basic_profile";

export default {
    namespaced: true,

    state: {
        name: "",
        email: window.currentProfile.email,
        avatar: "",
        account_type: "",
        general_info: null,
        education_info: null,
        previous_employments: [],
        preferred_lang: "en",
    },

    getters: {
        employmentById: (state) => (id) =>
            state.previous_employments.find((emp) => emp.id === parseInt(id)),

        current_location: (state) =>
            state.general_info ? state.general_info.location : "",
    },

    mutations: {
        setProfileDetails(
            state,
            { name, email, avatar, account_type, preferred_lang }
        ) {
            state.name = name;
            state.email = email;
            state.avatar = avatar;
            state.account_type = account_type;
            state.preferred_lang = preferred_lang;
        },

        setGeneralInfo(state, info) {
            state.general_info = info;
        },

        setEducationInfo(state, info) {
            state.education_info = info;
        },

        setPreviousEmployments(state, info) {
            state.previous_employments = info;
        },
    },

    actions: {
        refreshBasicInfo({ commit }) {
            return refreshProfileInfo()
                .then((info) => commit("setProfileDetails", info))
                .catch(() => showError("Unable to refresh profile info."));
        },

        fetchGeneralInfo({ commit }) {
            return fetchTeacherGeneralInfo().then((info) =>
                commit("setGeneralInfo", info)
            );
        },

        updateGeneralInfo({ dispatch }, formData) {
            return updateTeacherPersonalInfo(formData).then(() =>
                dispatch("fetchGeneralInfo").catch(() =>
                    showError("Unable to fetch profile info")
                )
            );
        },

        setLocation({ dispatch }, area_id) {
            return updateTeacherLocation(area_id).then(() =>
                dispatch("fetchGeneralInfo")
            );
        },

        fetchEducationInfo({ commit }) {
            return fetchTeacherEducationInfo().then((info) =>
                commit("setEducationInfo", info)
            );
        },

        updateEducation({ dispatch }, formData) {
            return updateTeacherEducationInfo(formData).then(() =>
                dispatch("fetchEducationInfo").catch(() =>
                    showError("Unable to fetch education info")
                )
            );
        },

        fetchPreviousEmployments({ commit }) {
            return fetchTeacherPreviousEmploymentInfo().then((info) =>
                commit("setPreviousEmployments", info)
            );
        },

        createPreviousEmployment({ dispatch }, formData) {
            return createTeacherPreviousEmployment(formData).then(() =>
                dispatch("fetchPreviousEmployments").catch(() =>
                    showError("Unable to fetch previous employment info")
                )
            );
        },

        updatePreviousEmployment({ dispatch }, { employment_id, formData }) {
            return updateTeacherPreviousEmployment(
                employment_id,
                formData
            ).then(() =>
                dispatch("fetchPreviousEmployments").catch(() =>
                    showError("Unable to fetch previous employment info")
                )
            );
        },

        deleteEmployment({ dispatch }, employment_id) {
            return deleteTeacherPreviousEmployment(employment_id).then(() =>
                dispatch("fetchPreviousEmployments").catch(() =>
                    showError("Unable to fetch previous employment info")
                )
            );
        },
    },
};
