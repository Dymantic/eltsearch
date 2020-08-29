import {
    addSchoolType,
    deleteSchoolType,
    fetchAllSchoolTypes,
    updateSchoolType,
} from "../../api/admin/school_types";
import { showError } from "../../libs/notifications";

export default {
    namespaced: true,

    state: {
        all: [],
    },

    getters: {
        schoolTypeById: (state) => (id) =>
            state.all.find((type) => type.id === parseInt(id)),
    },

    mutations: {
        setAll(state, school_types) {
            state.all = school_types;
        },
    },

    actions: {
        fetchAll({ commit }) {
            return fetchAllSchoolTypes().then((school_types) =>
                commit("setAll", school_types)
            );
        },

        refreshAll({ dispatch }) {
            dispatch("fetchAll").catch(() =>
                showError("Unable to fetch school types")
            );
        },

        createSchoolType({ dispatch }, formData) {
            return addSchoolType(formData).then(() => dispatch("refreshAll"));
        },

        updateType({ dispatch }, { type_id, formData }) {
            return updateSchoolType(type_id, formData).then(() =>
                dispatch("refreshAll")
            );
        },

        deleteType({ dispatch }, type_id) {
            return deleteSchoolType(type_id).then(() => dispatch("refreshAll"));
        },
    },
};
