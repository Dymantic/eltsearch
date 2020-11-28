import { get } from "../http";

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

function getSchoolById(school_id) {
    return get(`/api/admin/schools/${school_id}`);
}

export { getSchoolsOverview, getSchoolById, querySchools };
