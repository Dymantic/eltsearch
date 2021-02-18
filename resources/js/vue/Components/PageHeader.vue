<template>
    <div>
        <button
            type="button"
            @click="$router.go(-1)"
            class="muted-btn"
            v-if="back"
        >
            &larr; {{ trns("actions.back") }}
        </button>
        <div
            class="flex flex-col md:flex-row justify-between items-center mb-12 mt-2"
        >
            <p class="type-h3 capitalize text-center md:text-left mb-4 md:mb-0">
                {{ title }}
            </p>
            <div class="flex justify-center md:justify-end items-center">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
export default {
    props: ["title", "back"],
};
</script>
