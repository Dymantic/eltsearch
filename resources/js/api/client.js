import axios from "axios";

const httpClient = axios.create();

httpClient.interceptors.response.use(
    (response) => response,
    (error) => {
        if ([401, 419].includes(error.response.status)) {
            window.app.$router.push("/session-expired");
        }
        return Promise.reject(error);
    }
);

export { httpClient };
