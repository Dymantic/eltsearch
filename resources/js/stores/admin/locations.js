import {
    addAreaToRegion,
    addCountry,
    addRegionToCountry,
    fetchAllCountries,
    removeArea,
    removeCountry,
    removeRegion,
    renameCountry,
    updateAreaName,
    updateRegionName,
} from "../../api/admin/locations";
import { showError } from "../../libs/notifications";

export default {
    namespaced: true,

    state: {
        countries: [],
    },

    getters: {
        countryById: (state) => (id) =>
            state.countries.find((country) => country.id === parseInt(id)),
    },

    mutations: {
        setCountries(state, countries) {
            state.countries = countries;
        },
    },

    actions: {
        fetchCountries({ commit }) {
            return fetchAllCountries().then((countries) =>
                commit("setCountries", countries)
            );
        },

        refreshCountries({ dispatch }) {
            dispatch("fetchCountries").catch(() =>
                showError("Unable to fetch locations")
            );
        },

        saveCountry({ dispatch }, name) {
            return addCountry(name).then(() =>
                dispatch("fetchCountries").catch(() =>
                    showError("Unable to fetch locations.")
                )
            );
        },

        updateCountry({ dispatch }, { country_id, name }) {
            return renameCountry(country_id, name).then(() =>
                dispatch("refreshCountries")
            );
        },

        deleteCountry({ dispatch }, country_id) {
            return removeCountry(country_id).then(() =>
                dispatch("fetchCountries").catch(() =>
                    showError("Unable to fetch locations.")
                )
            );
        },

        addRegion({ dispatch }, { country_id, name }) {
            addRegionToCountry(country_id, name).then(() =>
                dispatch("fetchCountries").catch(() =>
                    showError("Unable to fetch locations.")
                )
            );
        },

        updateRegion({ dispatch }, { region_id, name }) {
            return updateRegionName(region_id, name).then(() =>
                dispatch("refreshCountries")
            );
        },

        deleteRegion({ dispatch }, region_id) {
            return removeRegion(region_id).then(() =>
                dispatch("refreshCountries")
            );
        },

        addArea({ dispatch }, { region_id, name }) {
            return addAreaToRegion(region_id, name).then(() =>
                dispatch("refreshCountries")
            );
        },

        updateArea({ dispatch }, { area_id, name }) {
            return updateAreaName(area_id, name).then(() =>
                dispatch("refreshCountries")
            );
        },

        deleteArea({ dispatch }, area_id) {
            return removeArea(area_id).then(() => dispatch("refreshCountries"));
        },
    },
};
