<template>
    <div
        class="relative"
        @mouseover="showMenu = true"
        @mouseleave="showMenu = false"
        @click="showMenu = !showMenu"
    >
        <div
            class="w-12 h-12 rounded-full border-2 border-blue-500 overflow-hidden"
        >
            <img
                :src="avatar"
                alt="my avatar"
                class="w-full h-full object-cover"
            />
        </div>
        <div
            class="p-6 shadow-lg absolute top-100 right-0 z-50 bg-white rounded-lg"
            :class="{ hidden: !showMenu }"
        >
            <div class="py-4 border-b">
                <p class="type-h4 text-navy">{{ username }}</p>
                <p class="type-b1 text-gray-600">{{ email }}</p>
                <p class="type-b2 text-sky-blue capitalize">
                    {{ account_type }}
                </p>
            </div>
            <div class="py-4">
                <router-link
                    to="/change-password"
                    class="block mb-2 whitespace-no-wrap hover:text-blue-600"
                    >{{ menu_items.password }}</router-link
                >
                <button @click="logout" class="hover:text-blue-600">
                    {{ menu_items.logout }}
                </button>
            </div>
            <div
                v-if="account_type === 'school'"
                class="mt-4 pt-4 border-t border-gray-300 flex justify-between px-6"
            >
                <button
                    :class="{
                        'font-bold text-sky-blue underline':
                            current_locale === 'en',
                    }"
                    :disabled="current_locale === 'en'"
                    @click="setLocale('en')"
                >
                    EN
                </button>
                <button
                    :class="{
                        'font-bold text-sky-blue underline':
                            current_locale === 'zh',
                    }"
                    :disabled="current_locale === 'zh'"
                    @click="setLocale('zh')"
                >
                    ZH
                </button>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import { post } from "../../api/http";

export default {
    data() {
        return {
            showMenu: false,
        };
    },

    computed: {
        username() {
            return this.$store.state.profile.name;
        },

        email() {
            return this.$store.state.profile.email;
        },

        account_type() {
            return this.$store.state.profile.account_type;
        },

        avatar() {
            return this.$store.state.profile.avatar;
        },

        menu_items() {
            return {
                password:
                    this.account_type === "school"
                        ? this.trns("nav.change_password")
                        : "Change password",
                logout:
                    this.account_type === "school"
                        ? this.trns("nav.logout")
                        : "Logout",
            };
        },

        current_locale() {
            if (!this.$store.state.lang) {
                return "en";
            }
            return this.$store.state.lang.locale;
        },
    },

    methods: {
        logout() {
            post("/logout", {}).then(() => (window.location = "/"));
        },

        setLocale(locale) {
            if (this.$store.state.lang.locale === locale) {
                return;
            }
            this.$store.commit("lang/setLocale", locale);
        },
    },
};
</script>
