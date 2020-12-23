<template>
    <div class="p-6 max-w-3xl my-12 border border-sky-blue shadow-lg">
        <p class="type-h3 text-sky-blue">Connect with Teachers</p>
        <p class="my-1">
            Here are some actions you can take to possibly connect with new
            teachers.
        </p>

        <dashboard-action
            url="/applications"
            action="Review Applications"
            :complete="!hasApplications"
            done="You don't have any recent applications at the moment."
            reason="Review applications from teachers who have applied to your job post."
        ></dashboard-action>

        <dashboard-action
            url="/notifications"
            action="Check your Messages"
            :complete="!hasUnreadMessages"
            done="You have no new messages."
            reason="Check up on your unread messages, there could be an opportunity waiting for you."
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
