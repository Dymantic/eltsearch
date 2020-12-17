import { get, post } from "../http";

function fetchTeacherRecruitmentAttempts() {
    return get("/api/teachers/recruitment-attempts");
}

function dismissTeacherRecruitmentAttempt(recruitment_attempt_id) {
    return post(`/api/teachers/dismissed-recruitment-attempts`, {
        recruitment_attempt_id,
    });
}

export { fetchTeacherRecruitmentAttempts, dismissTeacherRecruitmentAttempt };
