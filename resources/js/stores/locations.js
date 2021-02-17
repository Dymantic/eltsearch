import { allLocations } from "../api/shared/locations";

export default {
    namespaced: true,

    state: {
        all_locations: [],
        lang: "",
    },

    getters: {
        area_info: (state) => (area_id) => {
            area_id = parseInt(area_id);
            const country = state.all_locations.find((country) =>
                country.regions.some((region) =>
                    region.areas.some((area) => area.id === area_id)
                )
            );

            if (!country) {
                return {};
            }

            const region = country.regions.find((region) =>
                region.areas.some((area) => area.id === area_id)
            );
            const area = region.areas.find((area) => area.id === area_id);

            return {
                country_id: country.id,
                country_name: country.name,
                region_id: region.id,
                region_name: region.name,
                area_id: area.id,
                area_name: area.name,
                fullname: `${area.name}, ${region.name}, ${country.name}`,
            };
        },

        region_info: (state) => (region_id) => {
            region_id = parseInt(region_id);
            const country = state.all_locations.find((country) =>
                country.regions.some((region) => region.id === region_id)
            );

            if (!country) {
                return {};
            }

            const region = country.regions.find(
                (region) => region.id === region_id
            );

            return {
                country_id: country.id,
                country_name: country.name,
                region_id: region.id,
                region_name: region.name,
                fullname: `${region.name}, ${country.name}`,
            };
        },
    },

    mutations: {
        setLocations(state, { locations, lang }) {
            state.all_locations = locations;
            state.lang = lang;
        },
    },

    actions: {
        fetchLocations({ state, dispatch }, lang = "en") {
            if (state.all_locations.length && state.lang === lang) {
                return Promise.resolve();
            }

            dispatch("refresh", lang);
        },

        refresh({ commit }, lang) {
            return allLocations(lang).then((locations) =>
                commit("setLocations", { locations, lang })
            );
        },
    },
};
