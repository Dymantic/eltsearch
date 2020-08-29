<template>
    <div
        class="relative"
        @mouseover="showMenu = true"
        @mouseleave="showMenu = false"
        @click="showMenu = !showMenu"
    >
        <div class="w-12 h-12 rounded-full border-2 border-blue-500"></div>
        <div
            class="p-6 shadow-lg absolute top-100 right-0 z-50 bg-white"
            :class="{ hidden: !showMenu }"
        >
            <div class="py-4 border-b">
                <p class="font-bold">{{ username }}</p>
                <p class="text-gray-600">{{ email }}</p>
                <p class="text-sm uppercase text-gray-500">
                    {{ account_type }}
                </p>
            </div>
            <div class="py-4">
                <router-link
                    to="/change-password"
                    class="block mb-2 whitespace-no-wrap hover:text-blue-600"
                    >Change password</router-link
                >
                <button @click="logout" class="hover:text-blue-600">
                    Logout
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
    },

    methods: {
        logout() {
            post("/logout", {}).then(() => (window.location = "/"));
        },
    },
};
</script>
