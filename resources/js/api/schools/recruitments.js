import { get } from "../http";

function fetchRecentSchoolRecruitmentAttempts(school_id) {
    return get(`/api/schools/${school_id}/recruitment-attempts`);
}

export { fetchRecentSchoolRecruitmentAttempts };
