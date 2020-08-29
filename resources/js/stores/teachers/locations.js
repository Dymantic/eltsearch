import { allLocations } from "../../api/shared/locations";

export default {
    namespaced: true,

    state: {
        all_locations: [],
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
                return;
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
    },

    mutations: {
        setLocations(state, locations) {
            state.all_locations = locations;
        },
    },

    actions: {
        fetchLocations({ commit }) {
            return allLocations("en").then((locations) =>
                commit("setLocations", locations)
            );
        },
    },
};
