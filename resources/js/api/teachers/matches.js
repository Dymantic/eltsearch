import { del, get } from "../http";

function getTeacherJobMatches() {
    return get("/api/teachers/job-matches");
}

function dismissJobMatch(match_id) {
    return del(`/api/teachers/job-matches/${match_id}`);
}

export { getTeacherJobMatches, dismissJobMatch };
