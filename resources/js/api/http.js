import { httpClient } from "./client";

function get(url) {
    return new Promise((resolve, reject) => {
        httpClient
            .get(url)
            .then(({ data }) => resolve(data))
            .catch(({ response }) => reject(response));
    });
}

function post(url, data) {
    return new Promise((resolve, reject) => {
        httpClient
            .post(url, data)
            .then(({ data }) => resolve(data))
            .catch(({ response }) => reject(response));
    });
}

function del(url) {
    return new Promise((resolve, reject) => {
        httpClient
            .delete(url)
            .then(({ data }) => resolve(data))
            .catch(({ response }) => reject(response));
    });
}

function upload({ file, url, name, onUpdate }) {
    const payload = new FormData();
    payload.append(name, file);
    return new Promise((resolve, reject) => {
        httpClient
            .post(url, payload, {
                onUploadProgress: (ev) =>
                    onUpdate(parseInt((ev.loaded / ev.total) * 100)),
            })
            .then(({ data }) => resolve(data))
            .catch(({ response }) => reject(response));
    });
}

export { get, post, del, upload };
