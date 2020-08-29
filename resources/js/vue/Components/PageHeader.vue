<template>
    <div class="flex justify-between items-center mb-12">
        <p class="text-xl-xl font-bold">{{ title }}</p>
        <div class="flex justify-end items-center">
            <slot></slot>
        </div>
    </div>
</template>

<script type="text/babel">
export default {
    props: ["title"],
};
</script>
