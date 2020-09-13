<template>
    <div class="min-h-screen flex relative" :class="{ 'expose-nav': !hideNav }">
        <side-nav></side-nav>

        <div class="flex flex-col flex-1 lg:pl-80">
            <div
                class="h-20 bg-gray-100 shadow flex justify-end items-center px-6"
            >
                <button class="lg:hidden" @click="toggleNav">menu</button>
                <svg
                    class="mx-4 h-5 text-gray-500 fill-current"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                >
                    <path
                        d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"
                    />
                </svg>

                <profile-menu></profile-menu>
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

    mounted() {
        this.$store.commit("profile/setProfileDetails", window.currentProfile);
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
