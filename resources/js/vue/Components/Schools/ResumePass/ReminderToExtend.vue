<template>
    <div class="my-12 flex justify-between shadow p-6 rounded-lg">
        <p class="type-b1">
            Your resume pass will expire in
            <span class="type-b2">{{ passInfo.days_remaining }} days</span>.
        </p>
        <router-link
            to="/resume-passes/buy"
            class="type-b2 text-navy hover:text-sky-blue"
            >Get more time</router-link
        >
    </div>
</template>

<script type="text/babel">
export default {
    props: ["pass-info"],
};
</script>
