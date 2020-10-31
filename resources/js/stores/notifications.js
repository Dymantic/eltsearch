import {
    deleteNotification,
    fetchNotifications,
    markNotificationAsRead,
} from "../api/notifications";
import { showError } from "../libs/notifications";

export default {
    namespaced: true,

    state: {
        all: [],
    },

    getters: {
        hasUnread: (state) =>
            state.all.some((notification) => !notification.is_read),

        byId: (state) => (id) =>
            state.all.find((notification) => notification.id === id),
    },

    mutations: {
        setAll(state, notifications) {
            state.all = notifications;
        },
    },

    actions: {
        fetchAll({ dispatch, state }) {
            if (!state.all.length) {
                return dispatch("refresh");
            }

            return Promise.resolve();
        },

        refresh({ commit, rootGetters }) {
            return fetchNotifications()
                .then((notifications) => commit("setAll", notifications))
                .catch(() =>
                    showError(
                        rootGetters["lang/byKey"]("errors.fetch_notifications")
                    )
                );
        },

        markAsRead({ dispatch }, notification_id) {
            return markNotificationAsRead(notification_id).then(() =>
                dispatch("refresh")
            );
        },

        delete({ dispatch }, notification_id) {
            return deleteNotification(notification_id).then(() =>
                dispatch("refresh")
            );
        },
    },
};
