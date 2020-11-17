<template>
    <span
        class="type-b1 text-xs px-2 py-1 border rounded-lg"
        :class="colourClasses"
        >{{ text }}</span
    >
</template>

<script type="text/babel">
export default {
    props: ["colour", "text"],

    computed: {
        colourClasses() {
            const lookup = {
                green: "border-green-500 bg-green-200 text-green-700",
                teal: "border-teal-500 bg-teal-200 text-teal-700",
                orange: "border-orange-500 bg-orange-200 text-orange-700",
                red: "border-red-500 bg-red-200 text-red-700",
                indigo: "border-indigo-500 bg-indigo-200 text-indigo-700",
                purple: "border-purple-500 bg-purple-200 text-purple-700",
                gray: "border-gray-500 bg-gray-200 text-gray-700",
            };

            return lookup[this.colour];
        },
    },
};
</script>
