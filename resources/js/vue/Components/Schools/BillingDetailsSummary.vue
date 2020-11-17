<template>
    <div>
        <div>
            <div
                class="flex justify-between items-center border-b border-b-200 pb-2 mb-2"
            >
                <p class="type-b2">Billing Info:</p>
                <router-link
                    to="/billing-details"
                    class="type-b2 text-sky-blue hover:text-navy"
                    >Update Billing Info</router-link
                >
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2">
                <p>
                    <span class="type-b2">Address: </span
                    >{{ school.billing_address }}
                </p>
                <p>
                    <span class="type-b2">City: </span>{{ school.billing_city }}
                </p>
                <p>
                    <span class="type-b2">Country: </span
                    >{{ school.billing_country }}
                </p>
                <p>
                    <span class="type-b2">Postal Code: </span
                    >{{ school.billing_zip }}
                </p>
            </div>

            <div v-if="!complete">
                <p class="type-b2 mt-4">
                    <span class="text-sky-blue">Note: </span>
                    Your billing details are not complete. Please update your
                    billing info before you make any purchases.
                </p>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
export default {
    props: ["school"],

    computed: {
        complete() {
            return (
                this.school.billing_zip &&
                this.school.billing_country &&
                this.school.billing_city &&
                this.school.billing_address
            );
        },
    },
};
</script>
