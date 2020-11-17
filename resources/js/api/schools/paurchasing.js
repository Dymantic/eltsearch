import { get, post } from "../http";

function fetchSchoolPackages() {
    return get("/api/schools/packages");
}

function getSchoolPurchases(school_id) {
    return get(`/api/schools/${school_id}/purchases`);
}

function purchasePackageForSchool(school_id, formData) {
    return post(`/api/schools/${school_id}/purchases`, formData);
}

export { fetchSchoolPackages, purchasePackageForSchool, getSchoolPurchases };
