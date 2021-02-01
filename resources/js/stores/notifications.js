import {
    checkNewNotificationStatus,
    deleteNotification,
    fetchNotifications,
    markNotificationAsRead,
    markNotificationAsUnread,
} from "../api/notifications";
import { showError, showSuccess } from "../libs/notifications";

export default {
    namespaced: true,

    state: {
        all: [],
        last_fetched: null,
        timer: null,
    },

    getters: {
        hasUnread: (state) =>
            state.all.some((notification) => !notification.is_read),

        byId: (state) => (id) =>
            state.all.find((notification) => notification.id === id),
    },

    mutations: {
        setAll(state, { notifications, last_fetched }) {
            state.all = notifications;
            state.last_fetched = last_fetched;
        },

        setLastChecked(state, timestamp) {
            state.last_fetched = timestamp;
        },

        setTimerHandle(state, timer) {
            state.timer = timer;
        },

        cancelTimer(state) {
            window.clearInterval(state.timer);
            state.timer = null;
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
                .then((response_data) => commit("setAll", response_data))
                .catch(() =>
                    showError(
                        rootGetters["lang/byKey"]("errors.fetch_notifications")
                    )
                );
        },

        checkNew({ state, commit, dispatch }) {
            return checkNewNotificationStatus(state.last_fetched)
                .then(({ has_new, timestamp }) => {
                    commit("setLastChecked", timestamp);

                    if (has_new) {
                        showSuccess("You have a new message");
                        dispatch("refresh");
                        dispatch("general/refreshResources", null, {
                            root: true,
                        });
                    }
                })
                .catch(() => commit("cancelTimer"));
        },

        beginCheckTimer({ commit, dispatch }) {
            const timer = window.setInterval(
                () => dispatch("checkNew"),
                1000 * 60
            );
            commit("setTimerHandle", timer);
        },

        markAsRead({ dispatch }, notification_id) {
            return markNotificationAsRead(notification_id).then(() =>
                dispatch("refresh")
            );
        },

        unread({ dispatch }, notification_id) {
            return markNotificationAsUnread(notification_id).then(() =>
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
