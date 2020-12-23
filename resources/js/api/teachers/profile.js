import { get, post, del } from "../http";

function fetchTeacherDashboardStatuses() {
    return get("/api/teachers/dashboard-status");
}

function fetchTeacherGeneralInfo() {
    return get("/api/teachers/profile/general");
}

function updateTeacherPersonalInfo(formData) {
    return post("/api/teachers/profile/general", formData);
}

function fetchTeacherEducationInfo() {
    return get("/api/teachers/profile/education");
}

function updateTeacherEducationInfo(formData) {
    return post("/api/teachers/profile/education", formData);
}

function fetchTeacherPreviousEmploymentInfo() {
    return get("/api/teachers/previous-employments");
}

function createTeacherPreviousEmployment(formData) {
    return post("/api/teachers/previous-employments", formData);
}

function updateTeacherPreviousEmployment(employment_id, formData) {
    return post(
        `/api/teachers/previous-employments/${employment_id}`,
        formData
    );
}

function deleteTeacherPreviousEmployment(employment_id) {
    return del(`/api/teachers/previous-employments/${employment_id}`);
}

function updateTeacherLocation(area_id) {
    return post("/api/teachers/area", { area_id });
}

export {
    fetchTeacherDashboardStatuses,
    updateTeacherPersonalInfo,
    fetchTeacherGeneralInfo,
    fetchTeacherEducationInfo,
    updateTeacherEducationInfo,
    fetchTeacherPreviousEmploymentInfo,
    createTeacherPreviousEmployment,
    updateTeacherPreviousEmployment,
    deleteTeacherPreviousEmployment,
    updateTeacherLocation,
};
