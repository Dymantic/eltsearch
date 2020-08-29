export default {
    namespaced: true,

    state: {
        name: "",
        email: "",
        avatar: "",
        account_type: "",
    },

    mutations: {
        setProfileDetails(state, { name, email, avatar, account_type }) {
            state.name = name;
            state.email = email;
            state.avatar = avatar;
            state.account_type = account_type;
        },
    },
};
