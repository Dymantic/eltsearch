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
            reason="Your profile needs to be completed before you can start posting jobs."
        ></dashboard-action>

        <dashboard-action
            url="/billing-details"
            action="Add your Billing Details"
            :complete="hasBillingInfo"
            done="Your billing information is complete"
            reason="You need to add your billing information before you can start posting jobs or viewing teacher resumes."
        ></dashboard-action>
    </div>
</template>

<script type="text/babel">
import CheckIcon from "../../Icons/CheckIcon";
import DashboardAction from "../../Teachers/Dashboard/DashboardAction";
export default {
    components: { DashboardAction, CheckIcon },
    props: ["profile-incomplete", "has-billing-info"],
};
</script>
