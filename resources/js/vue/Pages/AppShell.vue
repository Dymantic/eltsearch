<template>
    <div
        class="min-h-screen flex relative w-screen"
        :class="{ 'expose-nav': !hideNav }"
    >
        <side-nav></side-nav>

        <div class="flex flex-col flex-1 lg:pl-80 max-w-full">
            <div
                class="h-20 bg-gray-100 shadow flex justify-between items-center px-6"
            >
                <button class="lg:hidden" @click="toggleNav">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        class="fill-current h-6 text-navy"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </button>
                <div class="flex justify-end items-center flex-1">
                    <router-link
                        to="/notifications"
                        class="inline-block rounded-full mx-4 p-2"
                        :class="{
                            'text-sky-blue': has_new_notifications,
                            'text-gray-600': !has_new_notifications,
                        }"
                    >
                        <svg
                            class="h-5 fill-current"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"
                            />
                        </svg>
                    </router-link>

                    <profile-menu></profile-menu>
                </div>
            </div>
            <div class="flex-1 p-6">
                <router-view></router-view>
            </div>
        </div>
        <notification-hub></notification-hub>
    </div>
</template>

<script type="text/babel">
import SideNav from "../Components/SideNav";
import ProfileMenu from "../Components/ProfileMenu";
import NotificationHub from "../Components/NotificationHub";
export default {
    components: {
        SideNav,
        ProfileMenu,
        NotificationHub,
    },

    data() {
        return {
            hideNav: true,
        };
    },

    computed: {
        has_new_notifications() {
            return this.$store.getters["notifications/hasUnread"];
        },
    },

    mounted() {
        this.$store.commit("profile/setProfileDetails", window.currentProfile);
        this.$store.commit(
            "lang/setLocale",
            this.$store.state.profile.preferred_lang
        );
        this.$store.dispatch("notifications/fetchAll");
    },

    watch: {
        $route() {
            this.hideNav = true;
        },
    },

    methods: {
        toggleNav() {
            this.hideNav = !this.hideNav;
        },
    },
};
</script>

<style>
@media screen and (max-width: 1024px) {
    .expose-nav .side-nav {
        transform: translate3d(0, 0, 0);
    }

    .side-nav {
        transform: translate3d(-100%, 0, 0);
    }
}
</style>
