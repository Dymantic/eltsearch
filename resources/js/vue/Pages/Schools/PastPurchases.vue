<template>
    <div v-if="school">
        <page-header :title="trns('purchases.title')"></page-header>

        <div class="my-12 shadow rounded-lg p-6">
            <table class="w-full">
                <thead>
                    <tr class="text-left border-b border-gray-300">
                        <th class="py-2">{{ trns("purchases.date") }}</th>
                        <th class="py-2">{{ trns("purchases.item") }}</th>
                        <th class="py-2">{{ trns("purchases.price") }}</th>
                        <th class="py-2">{{ trns("purchases.status") }}</th>
                        <th class="py-2">
                            {{ trns("purchases.purchased_by") }}
                        </th>
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
                                class="hover:text-sky-blue type-b2"
                            >
                                {{ purchase.package.name }}
                            </router-link>
                        </td>
                        <td class="py-1">{{ purchase.package.price }}</td>
                        <td class="p-1">
                            <colour-label
                                :colour="purchase.paid ? 'green' : 'red'"
                                :text="purchase.paid ? 'Paid' : 'Failed'"
                            ></colour-label>
                        </td>
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
import ColourLabel from "../../Components/ColourLabel";
export default {
    components: { BillingDetailsSummary, PageHeader, ColourLabel },

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
