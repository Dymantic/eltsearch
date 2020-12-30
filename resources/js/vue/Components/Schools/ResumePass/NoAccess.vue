<template>
    <div class="my-12 max-w-lg p-6 shadow rounded-lg">
        <p class="type-h3 mb-6">{{ trns("resume_pass.get_pass") }}</p>
        <p class="my-1">{{ trns("resume_pass.prompt_one") }}</p>
        <p class="my-1">{{ trns("resume_pass.prompt_two") }}</p>
        <div class="flex justify-end mt-6">
            <router-link to="/resume-passes/buy" class="btn btn-primary">{{
                trns("resume_pass.get_access")
            }}</router-link>
        </div>
    </div>
</template>

<script type="text/babel">
export default {
    props: ["pass-info"],
};
</script>
