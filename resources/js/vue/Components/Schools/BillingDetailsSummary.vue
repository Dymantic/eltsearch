<template>
    <div>
        <div>
            <div
                class="flex justify-between items-center border-b border-b-200 pb-2 mb-2"
            >
                <p class="type-b2">{{ trns("billing.info") }}</p>
                <router-link
                    to="/billing-details"
                    class="type-b2 text-sky-blue hover:text-navy"
                    >{{ trns("billing.update") }}</router-link
                >
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2">
                <p>
                    <span class="type-b2"
                        >{{ trns("billing.address_label") }}: </span
                    >{{ school.billing_address }}
                </p>
                <p>
                    <span class="type-b2"
                        >{{ trns("billing.city_label") }}: </span
                    >{{ school.billing_city }}
                </p>
                <p>
                    <span class="type-b2"
                        >{{ trns("billing.country_label") }}: </span
                    >{{ school.billing_country }}
                </p>
                <p>
                    <span class="type-b2"
                        >{{ trns("billing.zip_label") }}: </span
                    >{{ school.billing_zip }}
                </p>
            </div>

            <div v-if="!complete">
                <p class="type-b2 mt-4">
                    <span class="text-sky-blue"
                        >{{ trns("billing.note") }}:
                    </span>
                    {{ trns("billing.incomplete") }}
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
