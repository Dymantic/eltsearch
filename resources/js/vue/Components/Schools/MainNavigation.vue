<template>
    <div>
        <div class="mb-3">
            <router-link class="font-semibold text-white" to="/profile">{{
                trns("nav.profile")
            }}</router-link>
        </div>
        <div class="mb-3">
            <router-link class="font-semibold text-white" to="/job-posts">{{
                trns("nav.posts")
            }}</router-link>
        </div>
        <div class="mb-3">
            <router-link class="font-semibold text-white" to="/applications">{{
                trns("nav.applications")
            }}</router-link>
        </div>
        <div class="mb-3">
            <router-link class="font-semibold text-white" to="/notifications">{{
                trns("nav.notifications")
            }}</router-link>
        </div>
        <div class="mb-3">
            <router-link class="font-semibold text-white" to="/tokens">{{
                trns("nav.tokens")
            }}</router-link>
        </div>
        <div class="mb-3">
            <router-link class="font-semibold text-white" to="/resume-pass">{{
                trns("nav.resume_pass")
            }}</router-link>
        </div>
        <div class="mb-3">
            <router-link class="font-semibold text-white" to="/purchases">{{
                trns("nav.purchases")
            }}</router-link>
        </div>
    </div>
</template>

<script type="text/babel">
export default {};
</script>
