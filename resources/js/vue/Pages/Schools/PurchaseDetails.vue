<template>
    <div v-if="purchase">
        <page-header></page-header>

        <div class="my-12 flex justify-center">
            <div class="max-w-sm p-6 shadow rounded-lg">
                <div class="border-b border-gray-200">
                    <p class="type-h3">{{ purchase.package.name }}</p>
                    <p class="type-b2 text-gray-600">
                        {{ purchase.purchase_date }}
                    </p>
                    <p class="type-b1 my-6">
                        {{ purchase.package.description }}
                    </p>
                </div>

                <div class="border-b border-gray-200 py-4">
                    <p class="type-b2 mb-2">{{ purchase.package.price }}</p>
                    <div class="flex justify-between items-center">
                        <p class="capitalize mr-4">
                            {{ purchase.card_type }}: **** **** ****
                            {{ purchase.card_last_four }}
                        </p>
                        <colour-label
                            v-html="`Paid &check;`"
                            colour="green"
                        ></colour-label>
                    </div>
                </div>

                <p class="pt-4 type-b2">Ref no: {{ purchase.ref_no }}</p>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
import ColourLabel from "../../Components/ColourLabel";
export default {
    components: { ColourLabel, PageHeader },
    computed: {
        purchase() {
            return this.$store.getters["purchases/purchaseById"](
                this.$route.params.purchase
            );
        },

        school() {
            return this.$store.state.schoolprofile.current_school;
        },
    },

    mounted() {
        this.$store.dispatch("purchases/fetchPurchases", this.school.id);
    },
};
</script>
