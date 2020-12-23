<template>
    <div class="p-6 max-w-3xl my-12 border border-sky-blue shadow-lg">
        <p class="type-h3 text-sky-blue">Suggestions</p>
        <p class="my-1">
            Here are some things we suggest doing to increase your Job Search
            prospects.
        </p>

        <dashboard-action
            url="/tokens"
            action="Get Tokens"
            :complete="hasTokens"
            done="You have tokens in store."
            reason="You need to get tokens to post jobs. You can either get a single token, or a bunch at a discounted rate."
        ></dashboard-action>

        <dashboard-action
            url="/resume-pass"
            action="Get the Resume Pass"
            :complete="hasResumeAccess"
            done="You already have the resume pass"
            reason="Get the resume pass to browse and find teachers that suit your needs."
        ></dashboard-action>

        <dashboard-action
            url="/profile/images"
            action="Upload some images"
            :complete="!canAddImages"
            done="You already have added the maximum number of images"
            reason="Adding images of your school helps teachers see what your school is like and can increase your chances of finding a new teacher."
        ></dashboard-action>

        <dashboard-action
            url="/job-posts"
            action="Complete your Job Post"
            :complete="!hasDraftPosts"
            done="You don't have any incomplete job posts."
            reason="You have a job post that is still a draft. There is no time like the present to get that completed."
        ></dashboard-action>
    </div>
</template>

<script type="text/babel">
import DashboardAction from "../../Teachers/Dashboard/DashboardAction";
export default {
    components: { DashboardAction },

    props: [
        "has-tokens",
        "has-resume-access",
        "can-add-images",
        "has-draft-posts",
    ],
};
</script>
