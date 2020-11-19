export default {
    namespaced: true,

    state: {
        name: "",
        email: "",
        avatar: "",
        account_type: "",
        current_school_id: window.currentProfile.school_ids[0] || null,
        school_ids: [],
        preferred_lang: "en",
    },

    mutations: {
        setProfileDetails(
            state,
            { name, email, avatar, account_type, school_ids, preferred_lang }
        ) {
            state.name = name;
            state.email = email;
            state.avatar = avatar;
            state.account_type = account_type;
            state.school_ids = school_ids;
            state.preferred_lang = preferred_lang;
        },

        setProfileAvatar(state, avatar) {
            state.avatar = avatar;
        },
    },
};
