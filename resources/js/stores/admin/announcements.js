import {
    createAnnouncementForPublic,
    createAnnouncementForSchools,
    createAnnouncementForTeachers,
    deleteAnnouncement,
    getAnnouncements,
    updateAnnouncement,
} from "../../api/admin/announcements";
import { showError } from "../../libs/notifications";

export default {
    namespaced: true,

    state: {
        all: [],
    },

    getters: {
        currentForType: (state) => (type) =>
            state.all.filter((a) => a.type === type).find((a) => a.is_current),

        upcoming: (state) =>
            state.all.filter((a) => a.is_upcoming || a.is_current),

        byId: (state) => (id) => state.all.find((a) => a.id === parseInt(id)),
    },

    mutations: {
        setAnnouncements(state, announcements) {
            state.all = announcements;
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
            return getAnnouncements()
                .then((announcements) =>
                    commit("setAnnouncements", announcements)
                )
                .catch(() => showError("Failed to fetch announcements"));
        },

        createForPublic({ dispatch }, formData) {
            return createAnnouncementForPublic(formData).then(() =>
                dispatch("refresh")
            );
        },

        createForTeachers({ dispatch }, formData) {
            return createAnnouncementForTeachers(formData).then(() =>
                dispatch("refresh")
            );
        },

        createForSchools({ dispatch }, formData) {
            return createAnnouncementForSchools(formData).then(() =>
                dispatch("refresh")
            );
        },

        update({ dispatch }, { announcement_id, formData }) {
            return updateAnnouncement(announcement_id, formData).then(() =>
                dispatch("refresh")
            );
        },

        delete({ dispatch }, announcement_id) {
            return deleteAnnouncement(announcement_id).then(() =>
                dispatch("refresh")
            );
        },
    },
};
