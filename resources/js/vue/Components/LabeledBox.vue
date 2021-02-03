<template>
    <div class="my-12 p-6 lg:p-10 relative border border-gray-300 max-w-xl">
        <span
            class="type-h4 absolute top-0 left-0 px-2 py-1 bg-white text-blue-600 -mt-4 ml-4 border-gray-300 border capitalize"
            >{{ label }}</span
        >
        <slot></slot>
        <button
            v-if="dismissable"
            @click="$emit('dismiss')"
            class="pb-2 w-8 h-8 rounded-full border border-gray-400 hover:border-red-500 bg-gray-400 hover:bg-red-400 text-white absolute top-0 right-0 flex justify-center items-center -m-2 leading-none text-4xl font-semibold"
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
