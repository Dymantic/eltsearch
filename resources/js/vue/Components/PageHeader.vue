<template>
    <div class="flex justify-between items-center mb-12">
        <p class="type-h3">{{ title }}</p>
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
