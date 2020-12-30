<template>
    <div class="p-6 max-w-3xl my-12 border border-sky-blue shadow-lg">
        <p class="type-h3 text-sky-blue">
            {{ trns("dashboard.suggestions.title") }}
        </p>
        <p class="my-1">{{ trns("dashboard.suggestions.explain") }}</p>

        <dashboard-action
            url="/tokens"
            :action="trns('dashboard.suggestions.tokens_action')"
            :complete="hasTokens"
            :done="trns('dashboard.suggestions.tokens_done')"
            :reason="trns('dashboard.suggestions.tokens_reason')"
        ></dashboard-action>

        <dashboard-action
            url="/resume-pass"
            :action="trns('dashboard.suggestions.resume_action')"
            :complete="hasResumeAccess"
            :done="trns('dashboard.suggestions.resume_done')"
            :reason="trns('dashboard.suggestions.resume_reason')"
        ></dashboard-action>

        <dashboard-action
            url="/profile/images"
            :action="trns('dashboard.suggestions.images_action')"
            :complete="!canAddImages"
            :done="trns('dashboard.suggestions.images_done')"
            :reason="trns('dashboard.suggestions.images_reason')"
        ></dashboard-action>

        <dashboard-action
            url="/job-posts"
            :action="trns('dashboard.suggestions.post_action')"
            :complete="!hasDraftPosts"
            :done="trns('dashboard.suggestions.post_done')"
            :reason="trns('dashboard.suggestions.post_reason')"
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
