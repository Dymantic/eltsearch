<template>
    <div>
        <page-header :title="title">
            <form
                @submit.prevent="searchByName"
                class="mx-4 border border-sky-blue rounded-lg overflow-hidden"
            >
                <input
                    class="bg-gray-100 rounded-lg w-40 p-1 focus:outline-none"
                    placeholder="Search by name"
                    type="text"
                    v-model="search"
                />
                <button
                    type="submit"
                    class="type-b2 text-white bg-sky-blue py-1 px-2"
                >
                    Go
                </button>
            </form>
        </page-header>

        <div class="my-6 flex items-end flex-col" v-show="total_pages > 1">
            <p class="mb-2">Showing page {{ page }} of {{ total_pages }}.</p>
            <div class="flex items-center">
                <button
                    class="type-b2 text-sky-blue hover:text-navy focus:outline-none"
                    @click="previousPage"
                >
                    Prev
                </button>
                <div>
                    <form
                        @submit.prevent="jumpToPage"
                        class="mx-4 border border-sky-blue rounded-lg overflow-hidden"
                    >
                        <input
                            class="bg-gray-100 rounded-lg w-12 p-1 focus:outline-none"
                            type="text"
                            v-model="jump_page"
                        />
                        <button
                            type="submit"
                            class="type-b2 text-white bg-sky-blue p-1"
                        >
                            Go
                        </button>
                    </form>
                </div>
                <button
                    class="type-b2 text-sky-blue hover:text-navy focus:outline-none"
                    @click="nextPage"
                >
                    Next
                </button>
            </div>
        </div>

        <div class="my-12">
            <slot
                :list="items"
                :setOrder="setOrder"
                :order="order"
                :descending="descending"
            >
            </slot>
        </div>
        <busy-loading v-show="fetching"></busy-loading>
        <p class="my-8 text-gray-600" v-show="!items.length && !fetching">
            The are no results to display
        </p>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../PageHeader";
import BusyLoading from "../BusyLoading";
import { showError, showWarning } from "../../../libs/notifications";

export default {
    components: { PageHeader, BusyLoading },

    props: ["query", "initial-order", "initial-descending", "title"],

    data() {
        return {
            search: "",
            page: 1,
            items: [],
            order: this.initialOrder,
            fetching: true,
            descending: this.initialDescending,
            total_pages: 1,
            jump_page: null,
        };
    },

    mounted() {
        this.fetchItems();
    },

    methods: {
        fetchItems() {
            this.fetching = true;
            this.query(this.page, this.search, this.order, this.descending)
                .then((data) => {
                    this.total_pages = data.last_page;
                    this.items = data.items;
                })
                .catch(() => showError("Problem fetching data"))
                .then(() => (this.fetching = false));
        },

        setOrder(key, descending = false) {
            if (key === this.order) {
                this.descending = !this.descending;
            } else {
                this.order = key;
                this.descending = descending;
            }
            this.page = 1;

            this.fetchItems();
        },

        previousPage() {
            if (this.page < 2) {
                return;
            }
            this.page = this.page - 1;
            this.fetchItems();
        },

        nextPage() {
            if (this.page === this.total_pages) {
                return;
            }
            this.page = this.page + 1;
            this.fetchItems();
        },

        jumpToPage() {
            const pageInt = parseInt(this.jump_page);
            if (isNaN(pageInt)) {
                this.jump_page = "";
                return;
            }
            if (this.jump_page < 1 || this.jump_page > this.total_pages) {
                return showWarning(
                    `please select a page between 1 and ${this.total_pages}`
                );
            }
            this.page = parseInt(this.jump_page);
            this.jump_page = "";
            this.fetchItems();
        },

        searchByName() {
            this.page = 1;
            this.order = "name";
            this.descending = false;
            this.fetchItems();
        },
    },
};
</script>
