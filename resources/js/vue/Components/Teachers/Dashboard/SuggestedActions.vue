<template>
    <div class="p-6 max-w-3xl my-12 border border-sky-blue shadow-lg">
        <p class="type-h3 text-sky-blue">Suggestions</p>
        <p class="my-1">
            Here are some things we suggest doing to increase your Job Search
            prospects.
        </p>

        <dashboard-action
            url="/previous-employments"
            action="Add your Job Experience"
            :complete="hasExperience"
            done="You have some previous experience on record. Don't forget to add more if appropriate."
            reason="Adding your job experience lets employers know more about you, increasing your chances of getting hired."
        ></dashboard-action>

        <dashboard-action
            url="/profile"
            action="Set your Location"
            :complete="hasLocation"
            done="You have set your location."
            reason="This helps ELT Search make better matches with employers."
        ></dashboard-action>
    </div>
</template>

<script type="text/babel">
import DashboardAction from "./DashboardAction";
export default {
    components: { DashboardAction },

    props: ["has-experience", "has-location"],
};
</script>
