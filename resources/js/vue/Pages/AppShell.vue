<template>
    <div class="min-h-screen flex relative" :class="{ 'expose-nav': !hideNav }">
        <side-nav></side-nav>

        <div class="flex flex-col flex-1 lg:pl-80">
            <div
                class="h-20 bg-gray-100 shadow flex justify-end items-center px-6"
            >
                <button class="lg:hidden" @click="toggleNav">menu</button>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    class="fill-current mx-4 h-6 text-gray-500"
                >
                    <path
                        d="M14.65 8.512c-2.28-4.907-3.466-6.771-7.191-6.693-1.327.027-1.009-.962-2.021-.587-1.01.375-.143.924-1.177 1.773-2.902 2.383-2.635 4.587-1.289 9.84.567 2.213-1.367 2.321-.602 4.465.559 1.564 4.679 2.219 9.025.607 4.347-1.613 7.086-4.814 6.527-6.378-.765-2.145-2.311-.961-3.272-3.027zm-3.726 8.083c-3.882 1.44-7.072.594-7.207.217-.232-.65 1.253-2.816 5.691-4.463 4.438-1.647 6.915-1.036 7.174-.311.153.429-1.775 3.116-5.658 4.557zm-1.248-3.494c-2.029.753-3.439 1.614-4.353 2.389.643.584 1.847.726 3.046.281 1.527-.565 2.466-1.866 2.095-2.904l-.016-.036c-.251.082-.508.171-.772.27z"
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
