<template>
    <div v-if="notification">
        <page-header :title="trns('notifications.show_title')">
            <router-link to="/notifications" class="muted-btn"
                >&larr; {{ trns("notifications.back_button") }}</router-link
            >
        </page-header>
        <div class="my-12 max-w-md mx-auto rounded-lg shadow-lg p-8">
            <p class="type-b2">{{ notification.date_sent }}</p>
            <p class="my-6 type-h3">{{ notification.subject }}</p>
            <div>
                {{ notification.message }}
            </div>
            <div class="mt-6 text-center" v-if="has_action">
                <router-link :to="action_url" class="btn-primary btn">
                    {{ notification.action }}
                </router-link>
            </div>
        </div>
        <div
            class="my-12 flex flex-col md:flex-row justify-center items-center"
        >
            <button @click="deleteNotification" class="m-4">
                {{ trns("notifications.delete_button") }}
            </button>
            <button @click="unreadNotification" class="m-4">
                {{ trns("notifications.unread_button") }}
            </button>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../Components/PageHeader";
import { showError, showSuccess } from "../../libs/notifications";
export default {
    components: { PageHeader },

    data() {
        return {
            waiting: false,
        };
    },

    computed: {
        notification() {
            return this.$store.getters["notifications/byId"](
                this.$route.params.notification
            );
        },

        action_url() {
            return (
                this.notification.url.substring(
                    this.notification.url.indexOf("#") + 1
                ) || "/"
            );
        },

        has_action() {
            return (
                this.notification.url !== "" && this.notification.action !== ""
            );
        },
    },

    mounted() {
        this.$store.dispatch(
            "notifications/markAsRead",
            this.$route.params.notification
        );
    },

    methods: {
        deleteNotification() {
            this.waiting = true;

            this.$store
                .dispatch(
                    "notifications/delete",
                    this.$route.params.notification
                )
                .then(() => {
                    this.$router.push("/notifications");
                    showSuccess(this.trns("notifications.deleted"));
                })
                .catch(() => showError(this.trns("errors.delete_notification")))
                .then(() => (this.waiting = false));
        },

        unreadNotification() {
            this.$store
                .dispatch(
                    "notifications/unread",
                    this.$route.params.notification
                )
                .then(() => {
                    this.$router.push("/notifications");
                })
                .catch(() => showError(this.trns("errors.unread_notification")))
                .then(() => (this.waiting = false));
        },
    },
};
</script>
