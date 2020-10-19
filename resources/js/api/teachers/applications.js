import { get } from "../http";

function fetchTeacherApplications() {
    return get("/api/teachers/job-applications");
}

export { fetchTeacherApplications };
