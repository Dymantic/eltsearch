<template>
    <div>
        <page-header :title="trns('resume_pass.title')"></page-header>

        <product-list :buyables="passes" class="my-12"></product-list>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
import ProductList from "../../Components/Schools/ProductList";
export default {
    components: { ProductList, PageHeader },

    computed: {
        passes() {
            return this.$store.getters["purchases/resumePassPackages"];
        },
    },

    mounted() {
        this.$store.dispatch("purchases/fetchPackages");
    },
};
</script>
