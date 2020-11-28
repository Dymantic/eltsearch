import { del, get, post } from "../http";

function getAnnouncements() {
    return get("/api/admin/announcements");
}

function createAnnouncementForPublic(formData) {
    return post("/api/admin/public-announcements", formData);
}

function createAnnouncementForTeachers(formData) {
    return post("/api/admin/teacher-announcements", formData);
}

function createAnnouncementForSchools(formData) {
    return post("/api/admin/school-announcements", formData);
}

function updateAnnouncement(announcement_id, formData) {
    return post(`/api/admin/announcements/${announcement_id}`, formData);
}

function deleteAnnouncement(announcement_id) {
    return del(`/api/admin/announcements/${announcement_id}`);
}

export {
    getAnnouncements,
    createAnnouncementForPublic,
    createAnnouncementForSchools,
    createAnnouncementForTeachers,
    updateAnnouncement,
    deleteAnnouncement,
};
