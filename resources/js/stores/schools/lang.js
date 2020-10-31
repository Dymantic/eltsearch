import enTranslations from "../../lang/en";
import zhTranslations from "../../lang/zh";
import { setPreferredLang } from "../../api/lang";
import { showError } from "../../libs/notifications";

export default {
    namespaced: true,

    state: {
        locale: "en",
        en: enTranslations,
        zh: zhTranslations,
    },

    getters: {
        byKey: (state) => (key, fallback) => {
            const found = key.split(".").reduce((bag, next_key) => {
                return (bag || {})[next_key];
            }, state[state.locale]);

            if (state.locale === "en" || found) {
                return found || fallback;
            }

            return (
                key.split(".").reduce((bag, next_key) => {
                    return (bag || {})[next_key];
                }, state.en) || fallback
            );
        },
    },

    mutations: {
        setLocale(state, locale) {
            if (["en", "zh"].includes(locale)) {
                state.locale = locale;
            }
        },
    },

    actions: {
        updateLocale({ commit, rootGetters }, locale) {
            commit("setLocale", locale);
            return setPreferredLang(locale).catch(() =>
                showError(rootGetters["lang/byKey"]("errors.update_lang"))
            );
        },
    },
};
