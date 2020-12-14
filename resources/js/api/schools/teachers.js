import { get } from "../http";

function queryTeachers() {
    return get("/api/public-teachers");
}

export { queryTeachers };
