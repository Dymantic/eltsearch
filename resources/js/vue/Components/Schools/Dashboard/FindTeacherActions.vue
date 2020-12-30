<template>
    <div class="p-6 max-w-3xl my-12 border border-sky-blue shadow-lg">
        <p class="type-h3 text-sky-blue">
            {{ trns("dashboard.connect.title") }}
        </p>
        <p class="my-1">{{ trns("dashboard.connect.explain") }}</p>

        <dashboard-action
            url="/applications"
            :action="trns('dashboard.connect.applications_action')"
            :complete="!hasApplications"
            :done="trns('dashboard.connect.applications_done')"
            :reason="trns('dashboard.connect.applications_reason')"
        ></dashboard-action>

        <dashboard-action
            url="/notifications"
            :action="trns('dashboard.connect.messages_action')"
            :complete="!hasUnreadMessages"
            :done="trns('dashboard.connect.messages_done')"
            :reason="trns('dashboard.connect.messages_reason')"
        ></dashboard-action>
    </div>
</template>

<script type="text/babel">
import DashboardAction from "../../Teachers/Dashboard/DashboardAction";
export default {
    components: { DashboardAction },

    props: ["has-applications", "has-unread-messages"],
};
</script>
