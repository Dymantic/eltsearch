<template>
    <div>
        <page-header title="Sales">
            <router-link to="purchases/browse" class="btn btn-primary"
                >Browse</router-link
            >
        </page-header>

        <div class="my-12 flex flex-wrap">
            <number-stat
                class="md:mr-4 mb-4"
                :stat="total_count"
                title="Number of sales this month"
            ></number-stat>
            <number-stat
                class="md:mr-4 mb-4"
                :stat="month_revenue"
                title="Total revenue for this month"
            ></number-stat>
        </div>

        <div class="my-12">
            <p class="type-h4 mb-6">Recent Sales</p>
            <div class="p-6 shadow rounded-lg">
                <div
                    v-for="purchase in recent"
                    :key="purchase.id"
                    class="flex md:items-center flex-col md:flex-row mb-1 pb-1 border-b border-gray-200"
                >
                    <p class="mr-4 type-b3 w-24">
                        {{ purchase.purchase_date }}
                    </p>
                    <p class="type-b2 mr-4 w-48 truncate">
                        <router-link
                            :to="`/purchases/${purchase.id}/show`"
                            class="hover:text-sky-blue"
                            >{{ purchase.customer_name }}</router-link
                        >
                    </p>
                    <p class="w-24 mr-4">{{ purchase.pretty_price }}</p>
                    <p>{{ purchase.package.name }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../../Components/PageHeader";
import NumberStat from "../../../Components/NumberStat";
export default {
    components: { NumberStat, PageHeader },

    computed: {
        total_count() {
            return this.$store.state.purchases.total_this_month;
        },

        month_revenue() {
            return this.$store.state.purchases.total_revenue_for_month;
        },

        recent() {
            return this.$store.state.purchases.recent;
        },
    },

    mounted() {
        this.$store.dispatch("purchases/fetch");
    },
};
</script>
