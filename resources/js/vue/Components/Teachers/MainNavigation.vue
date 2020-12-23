<template>
    <div>
        <div class="mb-3">
            <router-link exact-active-class="" class="font-semibold" to="/"
                >Dashboard</router-link
            >
        </div>

        <div class="mb-3">
            <router-link class="font-semibold" to="/profile" active-class=""
                >My Profile</router-link
            >
        </div>

        <div class="mb-3">
            <router-link class="font-semibold" to="/previous-employments"
                >Employment History</router-link
            >
        </div>

        <div class="mb-3">
            <router-link class="font-semibold" to="/job-search/show"
                >Job Search</router-link
            >
        </div>

        <div class="mb-3">
            <router-link class="font-semibold" to="/job-matches"
                >Job Matches</router-link
            >
        </div>

        <div class="mb-3">
            <router-link class="font-semibold" to="/applications"
                >Job Applications</router-link
            >
        </div>

        <div class="mb-3">
            <router-link class="font-semibold" to="/notifications"
                >Messages</router-link
            >
        </div>
    </div>
</template>

<script type="text/babel">
export default {};
</script>
