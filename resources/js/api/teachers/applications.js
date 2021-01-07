import { get, post } from "../http";

function fetchTeacherApplications() {
    return get("/api/teachers/job-applications");
}

function applyForJob(formData) {
    return post("/api/teachers/job-applications", formData);
}

function getApplicationApproval(job_post_slug) {
    return post("/api/teachers/application-approvals", { job_post_slug });
}

export { fetchTeacherApplications, applyForJob, getApplicationApproval };
