import { post } from "./http";

function setPreferredLang(lang) {
    return post("/api/preferred-lang", { lang });
}

export { setPreferredLang };
