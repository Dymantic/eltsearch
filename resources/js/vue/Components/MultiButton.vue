<template>
    <button
        @click="open = !open"
        class="relative flex multi-btn focus:outline-none"
        :class="{ open: open }"
    >
        <span class="pr-2 border-r border-gray-300">{{ text }}</span>
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            class="fill-current h-5 ml-2"
        >
            <path
                fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd"
            />
        </svg>
        <div
            class="absolute left-0 right-0 top-100 bg-navy p-2 rounded-br-lg rounded-bl-lg flex flex-col items-end"
            v-show="open"
        >
            <slot></slot>
        </div>
    </button>
</template>

<script type="text/babel">
export default {
    props: ["text"],

    data() {
        return {
            open: false,
        };
    },

    created() {
        window.addEventListener("keydown", this.closeOnEsc);
        window.addEventListener("click", this.closeOnOuterClick);
    },

    destroyed() {
        window.removeEventListener("keydown", this.closeOnEsc);
        window.removeEventListener("click", this.closeOnOuterClick);
    },

    methods: {
        closeOnEsc({ key }) {
            if (key === "Escape") {
                this.open = false;
            }
        },

        closeOnOuterClick({ target }) {
            if (!this.$el.contains(target)) {
                this.open = false;
            }
        },
    },
};
</script>
