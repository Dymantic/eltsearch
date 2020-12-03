import { get } from "../http";

function queryPurchases(
    page = 1,
    search = "",
    order = "date",
    descending = true
) {
    const direction = descending ? "desc" : "asc";
    return get(
        `/api/admin/purchases?page=${page}&q=${search}&order=${order}&direction=${direction}`
    );
}

function getPurchasesOverview() {
    return get("/api/admin/purchases-overview");
}

function getPurchaseById(purchase_id) {
    return get(`/api/admin/purchases/${purchase_id}`);
}

export { queryPurchases, getPurchaseById, getPurchasesOverview };
