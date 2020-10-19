export default {
    namespaced: true,

    state: {
        name: "",
        email: "",
        avatar: "",
        account_type: "",
        school_ids: [],
    },

    mutations: {
        setProfileDetails(
            state,
            { name, email, avatar, account_type, school_ids }
        ) {
            state.name = name;
            state.email = email;
            state.avatar = avatar;
            state.account_type = account_type;
            state.school_ids = school_ids;
        },

        setProfileAvatar(state, avatar) {
            state.avatar = avatar;
        },
    },
};
