<template>
    <div
        class="side-nav fixed h-screen min-h-screen top-20 lg:top-0 w-80 max-w-full bg-navy transition-transform transition duration-200 z-50 p-6 text-white flex-shrink-0"
    >
        <a href="/">
            <alt-logo class="block w-48 text-white"></alt-logo>
        </a>
        <div class="pt-20">
            <main-navigation></main-navigation>
        </div>
    </div>
</template>

<script type="text/babel">
import AltLogo from "./AltLogo";
export default {
    components: {
        AltLogo,
    },
    computed: {
        navComponent() {
            return "main-navigation";
        },
    },
};
</script>
