<template>
    <router-link to="/tokens" class="text-sky-blue hover:text-navy">
        <div class="flex items-center px-4 py-1 border rounded-lg">
            <token-icon class="h-5"></token-icon>
            <span class="ml-4 type-h4">{{ tokens.length }}</span>
        </div>
    </router-link>
</template>

<script type="text/babel">
import TokenIcon from "../Icons/TokenIcon";
export default {
    components: {
        TokenIcon,
    },

    computed: {
        tokens() {
            return this.$store.state.tokens.valid;
        },
    },

    mounted() {
        this.$store.dispatch("tokens/fetchTokens");
    },
};
</script>
