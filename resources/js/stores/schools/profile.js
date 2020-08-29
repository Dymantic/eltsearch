export default {
    namespaced: true,

    state: {
        name: "",
        email: "",
        avatar: "",
        account_type: "",
        school_id: null,
    },

    mutations: {
        setProfileDetails(
            state,
            { name, email, avatar, account_type, school_id }
        ) {
            state.name = name;
            state.email = email;
            state.avatar = avatar;
            state.account_type = account_type;
            state.school_id = school_id;
        },
    },
};
