<template>
    <div>
        <page-header :title="trns('notifications.index_title')"> </page-header>
        <div v-if="notifications.length" class="my-12 shadow-lg p-4 rounded-lg">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="p-2 text-left">
                            {{ trns("notifications.received") }}
                        </th>
                        <th class="p-2 text-left">
                            {{ trns("notifications.sender") }}
                        </th>
                        <th class="p-2 text-left">
                            {{ trns("notifications.subject") }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="notification in notifications"
                        :key="notification.id"
                        class="border-b border-gray-300 last:border-b-0"
                        :class="{ 'font-bold': !notification.is_read }"
                    >
                        <td class="p-2">
                            <router-link
                                :to="`/notifications/${notification.id}`"
                                class="hover:text-sky-blue"
                            >
                                {{ notification.date_sent }}
                            </router-link>
                        </td>
                        <td class="p-2">
                            <router-link
                                :to="`/notifications/${notification.id}`"
                                class="hover:text-sky-blue"
                            >
                                {{ notification.sender }}
                            </router-link>
                        </td>
                        <td class="p-2">
                            <router-link
                                :to="`/notifications/${notification.id}`"
                                class="hover:text-sky-blue"
                            >
                                {{ notification.subject }}
                            </router-link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p v-else>{{ trns("notifications.empty_inbox") }}</p>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../Components/PageHeader";
export default {
    components: { PageHeader },

    computed: {
        notifications() {
            return this.$store.state.notifications.all;
        },
    },
};
</script>
