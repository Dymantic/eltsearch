<template>
    <div class="flex items-center">
        <router-link
            to="/resume-pass"
            class="hover:text-navy mx-2"
            :class="{
                'text-sky-blue': hasResumeAccess,
                'text-gray-500': !hasResumeAccess,
            }"
        >
            <div class="flex items-center px-4 py-1 border rounded-lg">
                <resume-pass-icon class="h-5"></resume-pass-icon>
            </div>
        </router-link>

        <router-link to="/tokens" class="text-sky-blue hover:text-navy">
            <div class="flex items-center px-4 py-1 border rounded-lg">
                <token-icon class="h-5"></token-icon>
                <span class="ml-4 type-h4">{{ tokens.length }}</span>
            </div>
        </router-link>
    </div>
</template>

<script type="text/babel">
import TokenIcon from "../Icons/TokenIcon";
import ResumePassIcon from "../Icons/ResumePassIcon";
export default {
    components: {
        ResumePassIcon,
        TokenIcon,
    },

    computed: {
        tokens() {
            return this.$store.state.tokens.valid;
        },

        hasResumeAccess() {
            return this.$store.state.purchases.resumePass.has_access;
        },
    },

    mounted() {
        this.$store.dispatch("tokens/fetchTokens");
        this.$store.dispatch("purchases/checkResumePass");
    },
};
</script>
