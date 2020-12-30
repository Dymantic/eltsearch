<template>
    <div class="p-6 max-w-3xl border border-sky-blue">
        <p class="type-h3 text-sky-blue">
            {{ trns("dashboard.essentials.title") }}
        </p>
        <p class="my-1">
            {{ trns("dashboard.essentials.explain") }}
        </p>

        <dashboard-action
            url="/profile"
            :action="trns('dashboard.essentials.complete_action')"
            :complete="!profileIncomplete"
            :done="trns('dashboard.essentials.complete_done')"
            :reason="trns('dashboard.essentials.complete_reason')"
        ></dashboard-action>

        <dashboard-action
            url="/billing-details"
            :action="trns('dashboard.essentials.billing_action')"
            :complete="hasBillingInfo"
            :done="trns('dashboard.essentials.billing_done')"
            :reason="trns('dashboard.essentials.billing_reason')"
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
