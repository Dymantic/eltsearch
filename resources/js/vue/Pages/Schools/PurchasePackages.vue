<template>
    <div v-if="school">
        <page-header title="Get Tokens">
            <p class="type-h4">You have {{ tokens.length }} token(s)</p>
        </page-header>

        <div class="my-12">
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
                    >Buy Now for {{ buyable.price }}</router-link
                >
            </div>
        </div>

        <billing-details-summary
            :school="school"
            class="my-12 mx-auto shadow p-6 rounded-lg"
        ></billing-details-summary>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
import BillingDetailsSummary from "../../Components/Schools/BillingDetailsSummary";
export default {
    components: { PageHeader, BillingDetailsSummary },

    computed: {
        buyables() {
            return this.$store.state.purchases.packages;
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
