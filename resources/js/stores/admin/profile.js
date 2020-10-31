export default {
    namespaced: true,

    state: {
        name: "",
        email: "",
        avatar: "",
        account_type: "",
        preferred_lang: "en",
    },

    mutations: {
        setProfileDetails(
            state,
            { name, email, avatar, account_type, preferred_lang }
        ) {
            state.name = name;
            state.email = email;
            state.avatar = avatar;
            state.account_type = account_type;
            state.preferred_lang = preferred_lang;
        },
    },
};
