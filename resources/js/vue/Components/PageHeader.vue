<template>
    <div class="flex flex-col md:flex-row justify-between items-center mb-12">
        <p class="type-h3 capitalize text-center md:text-left mb-4 md:mb-0">
            {{ title }}
        </p>
        <div class="flex justify-center md:justify-end items-center">
            <slot></slot>
        </div>
    </div>
</template>

<script type="text/babel">
export default {
    props: ["title"],
};
</script>
