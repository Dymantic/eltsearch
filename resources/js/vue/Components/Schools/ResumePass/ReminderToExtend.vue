<template>
    <div class="my-12 flex justify-between shadow p-6 rounded-lg">
        <p
            class="type-b1"
            v-html="
                trns('resume_pass.expires', '', {
                    days: passInfo.days_remaining,
                })
            "
        ></p>
        <router-link
            to="/resume-passes/buy"
            class="type-b2 text-navy hover:text-sky-blue"
            >{{ trns("resume_pass.extend") }}</router-link
        >
    </div>
</template>

<script type="text/babel">
export default {
    props: ["pass-info"],
};
</script>
