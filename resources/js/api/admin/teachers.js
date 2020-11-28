import { get } from "../http";

function fetchTeacherOverview() {
    return get("/api/admin/teachers-overview");
}

function queryTeachers(
    page = 1,
    search = "",
    order = "name",
    descending = false
) {
    const direction = descending ? "desc" : "asc";
    return get(
        `/api/admin/teachers?page=${page}&q=${search}&order=${order}&direction=${direction}`
    );
}

function fetchTeacherById(teacher_id) {
    return get(`/api/admin/teachers/${teacher_id}`);
}

export { fetchTeacherOverview, fetchTeacherById, queryTeachers };
