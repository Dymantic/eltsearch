<template>
    <div class="">
        <div
            v-for="buyable in buyables"
            :key="buyable.id"
            class="my-8 shadow p-6"
        >
            <p class="type-h4">{{ buyable.name }}</p>
            <p class="type-b1 mt-4 mb-6">{{ buyable.description }}</p>
            <router-link
                :to="`/purchasing/${buyable.id}`"
                class="btn btn-primary"
                >{{
                    trns("purchasing.buy_now", "", { price: buyable.price })
                }}</router-link
            >
        </div>
    </div>
</template>

<script type="text/babel">
export default {
    props: ["buyables"],
};
</script>
