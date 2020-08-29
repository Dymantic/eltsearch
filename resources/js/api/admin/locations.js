import { del, get, post } from "../http";

function fetchAllCountries() {
    return get("/api/admin/countries");
}

function addCountry(name) {
    return post("/api/admin/countries", name);
}

function renameCountry(country_id, name) {
    return post(`/api/admin/countries/${country_id}`, name);
}

function removeCountry(country_id) {
    return del(`/api/admin/countries/${country_id}`);
}

function addRegionToCountry(country_id, name) {
    return post(`/api/admin/countries/${country_id}/regions`, name);
}

function updateRegionName(region_id, name) {
    return post(`/api/admin/regions/${region_id}`, name);
}

function removeRegion(region_id) {
    return del(`/api/admin/regions/${region_id}`);
}

function addAreaToRegion(region_id, name) {
    return post(`/api/admin/regions/${region_id}/areas`, name);
}

function updateAreaName(area_id, name) {
    return post(`/api/admin/areas/${area_id}`, name);
}

function removeArea(area_id) {
    return del(`/api/admin/areas/${area_id}`);
}

export {
    addCountry,
    fetchAllCountries,
    renameCountry,
    removeCountry,
    addRegionToCountry,
    updateRegionName,
    removeRegion,
    addAreaToRegion,
    updateAreaName,
    removeArea,
};
