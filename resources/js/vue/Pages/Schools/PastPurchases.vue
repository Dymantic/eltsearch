<template>
    <div v-if="school">
        <page-header title="Your purchases"></page-header>

        <div class="my-12 shadow rounded-lg p-6">
            <table class="w-full">
                <thead>
                    <tr class="text-left border-b border-gray-300">
                        <th class="py-2">Date</th>
                        <th class="py-2">Item</th>
                        <th class="py-2">Price</th>
                        <th class="py-2">Purchased By</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="purchase in purchases">
                        <td class="py-1">
                            <router-link
                                :to="`/purchases/${purchase.id}`"
                                class="hover:text-sky-blue"
                            >
                                {{ purchase.purchase_date }}
                            </router-link>
                        </td>
                        <td class="py-1">
                            <router-link
                                :to="`/purchases/${purchase.id}`"
                                class="hover:text-sky-blue"
                            >
                                {{ purchase.package.name }}
                            </router-link>
                        </td>
                        <td class="py-1">{{ purchase.package.price }}</td>
                        <td class="py-1">{{ purchase.user.name }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
import BillingDetailsSummary from "../../Components/Schools/BillingDetailsSummary";
export default {
    components: { BillingDetailsSummary, PageHeader },

    computed: {
        school() {
            return this.$store.state.schoolprofile.current_school;
        },

        purchases() {
            return this.$store.state.purchases.purchases;
        },
    },

    mounted() {
        this.$store.dispatch("purchases/fetchPurchases", this.school.id);
    },
};
</script>
