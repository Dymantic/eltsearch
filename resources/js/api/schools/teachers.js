import { get } from "../http";

function queryTeachers(
    school_id,
    {
        page = 1,
        area = 0,
        order = "name",
        direction = "asc",
        exp_level = 0,
        nation = 0,
    }
) {
    return get(
        `/api/schools/${school_id}/public-teachers?page=${page}&near=${area}&exp_level=${exp_level}&nation=${nation}&order=${order}&direction=${direction}`
    );
}

function fetchTeacherBySlug(school_id, teacher_slug) {
    return get(`/api/schools/${school_id}/public-teachers/${teacher_slug}`);
}

export { queryTeachers, fetchTeacherBySlug };
