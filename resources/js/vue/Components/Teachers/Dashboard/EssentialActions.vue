<template>
    <div class="p-6 max-w-3xl border border-sky-blue">
        <p class="type-h3 text-sky-blue">Essentials</p>
        <p class="my-1">
            This is what you need to do before you can get started.
        </p>

        <dashboard-action
            url="/profile"
            action="Complete Your Profile"
            :complete="!profileIncomplete"
            done="Your profile is complete."
            reason="Your profile and education information need to be completed before you may apply for jobs."
        ></dashboard-action>
    </div>
</template>

<script type="text/babel">
import CheckIcon from "../../Icons/CheckIcon";
import DashboardAction from "./DashboardAction";
export default {
    components: { DashboardAction, CheckIcon },
    props: ["profile-incomplete"],
};
</script>
