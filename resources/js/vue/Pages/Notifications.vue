<template>
    <div>
        <page-header :title="trns('notifications.index_title')"> </page-header>
        <div v-if="notifications.length" class="my-12 shadow-lg p-4 rounded-lg">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="p-2 text-left"></th>
                        <th class="p-2 text-left">
                            {{ trns("notifications.received") }}
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
                    >
                        <td class="w-16 text-center px-2 py-1">
                            <div
                                class="w-3 h-3 rounded-full mx-auto"
                                :class="{
                                    'bg-gray-300': notification.is_read,
                                    'bg-sky-blue': !notification.is_read,
                                }"
                            ></div>
                        </td>
                        <td class="p-2">{{ notification.date_sent }}</td>
                        <td class="p-2">
                            <router-link
                                :to="`/notifications/${notification.id}`"
                                class="hover:text-navy"
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
