<template>
    <div>
        <div v-if="!sale && fetching">
            <busy-loading></busy-loading>
        </div>
        <div v-if="sale && !fetching">
            <page-header :title="sale.ref_no"></page-header>

            <div class="max-w-xl mx-auto p-6 rounded-lg shadow">
                <div
                    class="flex justify-between items-center border-b border-gray-200 mb-4 pb-2"
                >
                    <p class="type-b2">{{ sale.purchase_date }}</p>
                    <p class="type-h3 text-sky-blue">{{ sale.pretty_price }}</p>
                </div>
                <div class="my-6">
                    <p class="type-h4">{{ sale.package.name }}</p>
                    <p class="type-b1">{{ sale.package.description }}</p>
                </div>
                <div class="flex my-6">
                    <div class="mr-8">
                        <p class="type-b4 text-navy">ELT Ref no:</p>
                        <p class="type-h4 text-gray-600">{{ sale.ref_no }}</p>
                    </div>
                    <div>
                        <p class="type-b4 text-navy">2Checkout ref no:</p>
                        <p class="type-h4 text-gray-600">
                            {{ sale.gateway_ref_no }}
                        </p>
                    </div>
                </div>
                <div class="my-6 border-t border-grey-200 pt-6">
                    <div class="flex items-center">
                        <colour-label
                            :colour="status.colour"
                            :text="status.text"
                        ></colour-label>
                        <p class="capitalize mx-4">{{ sale.card_type }}</p>
                        <p>**** **** **** {{ sale.card_last_four }}</p>
                    </div>
                    <p class="type-b1 text-red-600 mt-4" v-show="sale.error">
                        {{ sale.error }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../../Components/PageHeader";
import BusyLoading from "../../../Components/BusyLoading";
import { showError } from "../../../../libs/notifications";
import ColourLabel from "../../../Components/ColourLabel";
export default {
    components: { ColourLabel, PageHeader, BusyLoading },

    data() {
        return {
            fetching: true,
            sale: null,
        };
    },

    computed: {
        status() {
            if (!this.sale) {
                return { colour: "gray", text: "   " };
            }

            const colour = this.sale.paid ? "green" : "red";
            const text = this.sale.paid ? "paid" : "failed";

            return { colour, text };
        },
    },

    mounted() {
        this.$store
            .dispatch("purchases/getById", this.$route.params.purchase)
            .then((purchase) => (this.sale = purchase))
            .catch(() => showError("Unable to find sale info"))
            .then(() => (this.fetching = false));
    },
};
</script>
