import { del, get, post } from "../http";

function getSchoolsOverview() {
    return get("/api/admin/schools-overview");
}

function querySchools(
    page = 1,
    search = "",
    order = "name",
    descending = false
) {
    const direction = descending ? "desc" : "asc";
    return get(
        `/api/admin/schools?page=${page}&q=${search}&order=${order}&direction=${direction}`
    );
}

function disableSchool(school_id) {
    return post("/api/admin/disabled-schools", { school_id });
}

function reinstateSchool(school_id) {
    return del(`/api/admin/disabled-schools/${school_id}`);
}

function getSchoolById(school_id) {
    return get(`/api/admin/schools/${school_id}`);
}

export {
    getSchoolsOverview,
    getSchoolById,
    querySchools,
    disableSchool,
    reinstateSchool,
};
