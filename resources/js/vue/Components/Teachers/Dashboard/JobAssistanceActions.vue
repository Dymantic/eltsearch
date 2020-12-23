<template>
    <div class="p-6 max-w-3xl my-12 border border-sky-blue shadow-lg">
        <p class="type-h3 text-sky-blue">Job Assistance</p>
        <p class="my-1">
            Here are some actions you could take to help with your job search.
        </p>

        <dashboard-action
            url="/job-search/show"
            action="Create a Job Search"
            :complete="hasJobSearch"
            done="We know what you are looking for, and the search is underway. Remember to update your preferences if you so desire."
            reason="This is the fastest and easiest way to find a job on ELT Search. Create a Job Search to be automatically matched with schools that are hiring. Update your preferences anytime."
        ></dashboard-action>

        <dashboard-action
            url="/job-matches"
            action="See your Job Matches"
            :complete="!hasMatches"
            done="We don't have any recent job matches for you."
            reason="You have some job matches based on your Job Search. Check these out now, your new job may be waiting."
        ></dashboard-action>
    </div>
</template>

<script type="text/babel">
import DashboardAction from "./DashboardAction";
export default {
    components: { DashboardAction },

    props: ["has-job-search", "has-matches"],
};
</script>
