<template>
    <div v-if="product">
        <page-header :title="product.name"></page-header>

        <p class="my-8 max-w-lg">{{ product.description }}</p>

        <div class="flex justify-between flex-col md:flex-row">
            <div class="w-full md:w-1/2">
                <div v-if="!has_complete_billing_info">
                    <p class="my-2">
                        Your billing info is incomplete. Please update before
                        you proceed.
                    </p>
                    <router-link
                        to="/billing-details"
                        class="type-b2 text-sky-blue hover:text-navy"
                        >Edit billing info</router-link
                    >
                </div>

                <form v-else @submit.prevent="purchase" class="max-w-md">
                    <text-field
                        :disabled="waiting"
                        label="Name"
                        v-model="cardholder"
                        class="mr-6 mb-2"
                    ></text-field>
                    <div class="" style="min-height: 10rem;">
                        <div ref="card" id="card-element"></div>
                    </div>

                    <submit-button :waiting="waiting">
                        Purchase
                    </submit-button>
                </form>
                <div v-show="last_error">
                    <p class="max-w-lg my-6 type-b2 text-red-600">
                        {{ last_error }}
                    </p>
                </div>
            </div>
            <div class="w-full md:w-1/2">
                <div class="pl-8">
                    <p class="type-h4 mb-2">Billing Info:</p>
                    <p class="mb-1">
                        <span class="type-b2">Address: </span
                        >{{ billing_info.address }}
                    </p>
                    <p class="mb-1">
                        <span class="type-b2">City: </span
                        >{{ billing_info.city }}
                    </p>
                    <p class="mb-1">
                        <span class="type-b2">Country: </span
                        >{{ billing_info.country }}
                    </p>
                    <p class="mb-1">
                        <span class="type-b2">Postal Code: </span
                        >{{ billing_info.zip }}
                    </p>
                    <router-link
                        to="/billing-details"
                        class="text-sky-blue hover:text-navy"
                        >Edit billing info</router-link
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
import TextField from "../../Components/Forms/TextField";
import SubmitButton from "../../Components/Forms/SubmitButton";
import { showError, showSuccess } from "../../../libs/notifications";

export default {
    components: { TextField, PageHeader, SubmitButton },

    data() {
        return {
            waiting: false,
            cardholder: "",
            client: null,
            checkout_component: null,
            last_error: "",
        };
    },

    computed: {
        product() {
            return this.$store.getters["purchases/packageById"](
                this.$route.params.package
            );
        },

        school_id() {
            return this.$store.state.schoolprofile.current_school.id;
        },

        two_checkout() {
            return this.$store.state.purchases.two_checkout;
        },

        has_complete_billing_info() {
            return this.$store.getters["schoolprofile/hasCompleteBillingInfo"];
        },

        billing_info() {
            return this.$store.getters["schoolprofile/billingInfo"];
        },
    },

    mounted() {
        this.$store.dispatch("purchases/fetchPackages");

        this.initCheckout();
    },

    methods: {
        initCheckout() {
            this.client = new TwoPayClient(this.two_checkout.merchant_code);
            this.checkout_component = this.client.components.create("card");
            window.setTimeout(() => {
                this.checkout_component.mount("#card-element");
            }, 200);
        },

        getToken() {
            return this.client.tokens
                .generate(this.checkout_component, { name: this.cardholder })
                .then((response) => response.token);
        },

        async purchase() {
            this.waiting = true;
            this.last_error = "";

            const token = await this.getToken().catch(() =>
                showError("Failed to start transaction")
            );

            if (!token) {
                this.waiting = false;
                return;
            }

            this.$store
                .dispatch("purchases/purchasePackage", {
                    school_id: this.school_id,
                    formData: {
                        package_id: this.product.id,
                        token,
                        name: this.cardholder,
                    },
                })
                .then(this.onSuccess)
                .catch(() => showError("Payment failed"))
                .then(() => (this.waiting = false));
        },

        onSuccess(purchase) {
            if (purchase.paid) {
                showSuccess("Payment complete");
                return this.$router.push("/purchases");
            }

            this.last_error = purchase.error;
            showError("Payment was not successful");
        },
    },
};
</script>
