<template>
    <transition name="fade">
        <div
            v-if="current"
            class="fixed bottom-0 left-50 mb-8 z-50 w-screen max-w-md py-3 border rounded-lg text-center transform -translate-x-1/2 flex items-center px-4"
            :class="boundClasses"
        >
            <svg
                class="h-4 fill-current mr-4 text-green-500"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                v-if="current.type === 'success'"
            >
                <path
                    d="M8.294 16.998c-.435 0-.847-.203-1.111-.553L3.61 11.724a1.392 1.392 0 0 1 .27-1.951 1.392 1.392 0 0 1 1.953.27l2.351 3.104 5.911-9.492a1.396 1.396 0 0 1 1.921-.445c.653.406.854 1.266.446 1.92L9.478 16.34a1.39 1.39 0 0 1-1.12.656c-.022.002-.042.002-.064.002z"
                />
            </svg>
            <svg
                class="h-4 mr-4 fill-current text-red-500"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                v-if="current.type === 'error'"
            >
                <path
                    d="M10.001.4C4.698.4.4 4.698.4 10a9.6 9.6 0 0 0 9.601 9.601c5.301 0 9.6-4.298 9.6-9.601-.001-5.302-4.3-9.6-9.6-9.6zM10 17.599a7.6 7.6 0 1 1 0-15.2 7.6 7.6 0 0 1 0 15.2zm2.501-7.849c.828 0 1.5-.783 1.5-1.75s-.672-1.75-1.5-1.75-1.5.783-1.5 1.75.671 1.75 1.5 1.75zm-5 0c.828 0 1.5-.783 1.5-1.75s-.672-1.75-1.5-1.75-1.5.783-1.5 1.75.671 1.75 1.5 1.75zm2.501 1.5c-3.424 0-4.622 2.315-4.672 2.414a.75.75 0 0 0 1.342.672c.008-.017.822-1.586 3.33-1.586 2.463 0 3.298 1.527 3.328 1.585a.75.75 0 1 0 1.342-.67c-.049-.099-1.246-2.415-4.67-2.415z"
                />
            </svg>
            <svg
                class="h-4 mr-4 fill-current text-orange-500"
                v-if="current.type === 'warning'"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
            >
                <path
                    class="heroicon-ui"
                    d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20zm0 2a8 8 0 1 0 0 16 8 8 0 0 0 0-16zm0 9a1 1 0 0 1-1-1V8a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1zm0 4a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"
                />
            </svg>
            <p class="flex-1 text-center">{{ current.message }}</p>
            <button
                v-if="current.confirm"
                class="font-bold text-xs hover:underline ml-4"
                @click="clearNotification(current)"
            >
                Dismiss
            </button>
        </div>
    </transition>
</template>

<script type="text/babel">
export default {
    computed: {
        current() {
            return this.notifications.sort(
                (a, b) => a.timestamp - b.timestamp
            )[0];
        },

        notifications() {
            return this.$store.state.notifications.queue;
        },

        boundClasses() {
            if (!this.current) {
                return "";
            }

            const type = this.current.type;
            const lookup = {
                success: "bg-green-100 border-green-500",
                error: "bg-red-100 border-red-500",
                warning: "bg-orange-100 border-orange-500",
            };

            return lookup[type];
        },
    },

    watch: {
        current(to, from) {
            if (to && !to.confirm) {
                window.setTimeout(() => {
                    this.clearNotification(to);
                }, 2000);
            }
        },
    },

    methods: {
        clearNotification(notification) {
            this.$store.commit("notifications/clear", notification);
        },
    },
};
</script>

<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s, transform 0.5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
    transform: scale(0);
}
</style>
