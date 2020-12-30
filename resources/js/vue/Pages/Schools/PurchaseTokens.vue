<template>
    <div v-if="school">
        <page-header :title="trns('tokens.get_tokens')">
            <p class="type-h4">
                {{ trns("tokens.token_count", "", { count: tokens.length }) }}
            </p>
        </page-header>

        <product-list :buyables="buyables" class="my-12"></product-list>

        <billing-details-summary
            :school="school"
            class="my-12 mx-auto shadow p-6 rounded-lg"
        ></billing-details-summary>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
import BillingDetailsSummary from "../../Components/Schools/BillingDetailsSummary";
import ProductList from "../../Components/Schools/ProductList";
export default {
    components: { ProductList, PageHeader, BillingDetailsSummary },

    computed: {
        buyables() {
            return this.$store.getters["purchases/tokenPackages"];
        },

        tokens() {
            return this.$store.state.tokens.valid;
        },

        school() {
            return this.$store.state.schoolprofile.current_school;
        },
    },
    mounted() {
        this.$store.dispatch("purchases/fetchPackages");
        this.$store.dispatch("tokens/fetchTokens", this.school.id);
    },
};
</script>
