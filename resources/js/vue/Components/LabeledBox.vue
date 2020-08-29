<template>
    <div class="my-12 p-6 lg:p-10 relative border border-gray-300">
        <span
            class="text-sm absolute top-0 left-0 px-2 py-1 bg-white text-blue-600 -mt-4 ml-4 border-gray-300 border"
            >{{ label }}</span
        >
        <slot></slot>
        <button
            v-if="dismissable"
            @click="$emit('dismiss')"
            class="w-6 h-6 rounded-full border border-gray-300 bg-white hover:bg-red-100 text-red-600 absolute top-0 right-0 flex justify-center items-center -m-2"
        >
            &times;
        </button>
    </div>
</template>

<script type="text/babel">
export default {
    props: {
        label: String,
        dismissable: {
            type: Boolean,
            default: true,
        },
    },
};
</script>
