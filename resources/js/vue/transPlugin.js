export default {
    install(Vue, options) {
        Vue.mixin({
            methods: {
                trns(key, fallback = "") {
                    if (!this.$store.state.lang) {
                        return fallback;
                    }

                    return this.$store.getters["lang/byKey"](key, fallback);
                },
            },
        });
    },
};
