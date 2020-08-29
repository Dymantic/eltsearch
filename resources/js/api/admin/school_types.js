import { del, get, post } from "../http";

function fetchAllSchoolTypes() {
    return get("/api/admin/school-types");
}

function addSchoolType(formData) {
    return post("/api/admin/school-types", formData);
}

function updateSchoolType(type_id, formData) {
    return post(`/api/admin/school-types/${type_id}`, formData);
}

function deleteSchoolType(type_id) {
    return del(`/api/admin/school-types/${type_id}`);
}

export {
    fetchAllSchoolTypes,
    addSchoolType,
    updateSchoolType,
    deleteSchoolType,
};
