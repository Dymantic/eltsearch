<template>
    <div
        class="md:w-48 md:h-40 md:border md:border-sky-blue shadow-md flex md:justify-between md:items-center md:flex-col md:p-4 p-2"
    >
        <span
            class="text-base md:text-5xl text-sky-blue font-bold mr-2 md:mr-0"
            >{{ stat }}</span
        >
        <p class="text-gray-600 text-center">
            {{ title }}
        </p>
    </div>
</template>

<script type="text/babel">
export default { props: ["stat", "title"] };
</script>
