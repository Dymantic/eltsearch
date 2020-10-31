import { del, get, post } from "./http";

function fetchNotifications() {
    return get("/api/notifications");
}

function markNotificationAsRead(notification_id) {
    return post("/api/read-notifications", { notification_id });
}

function deleteNotification(notification_id) {
    return del(`/api/notifications/${notification_id}`);
}

export { fetchNotifications, markNotificationAsRead, deleteNotification };
