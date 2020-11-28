<template>
    <div class="flex justify-center">
        <div class="h-3 w-3 bg-sky-blue rounded-full mx-1 bobbing"></div>
        <div class="h-3 w-3 bg-sky-blue rounded-full mx-1 bobbing"></div>
        <div class="h-3 w-3 bg-sky-blue rounded-full mx-1 bobbing"></div>
    </div>
</template>

<script type="text/babel">
export default {};
</script>

<style>
.bobbing {
    animation-name: "bobbing";
    animation-duration: 0.7s;
    animation-fill-mode: both;
    animation-direction: alternate;
    animation-iteration-count: infinite;
}

.bobbing:nth-child(1) {
    animation-delay: 0.2s;
}

.bobbing:nth-child(2) {
    animation-delay: 0.4s;
}

.bobbing:nth-child(3) {
    animation-delay: 0.6s;
}
@keyframes bobbing {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}
</style>
