import { get, post } from "../http";

function fetchTeacherApplications() {
    return get("/api/teachers/job-applications");
}

function applyForJob(formData) {
    return post("/api/teachers/job-applications", formData);
}

export { fetchTeacherApplications, applyForJob };
