import axios from "axios";
function get(url) {
    return new Promise((resolve, reject) => {
        axios
            .get(url)
            .then(({ data }) => resolve(data))
            .catch(({ response }) => reject(response));
    });
}

function post(url, data) {
    return new Promise((resolve, reject) => {
        axios
            .post(url, data)
            .then(({ data }) => resolve(data))
            .catch(({ response }) => reject(response));
    });
}

function del(url) {
    return new Promise((resolve, reject) => {
        axios
            .delete(url)
            .then(({ data }) => resolve(data))
            .catch(({ response }) => reject(response));
    });
}

export { get, post, del };
