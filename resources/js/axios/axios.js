import _axios from "axios";

_axios.defaults.headers.common['Accept'] = 'application/json';

const axios = _axios.create();

axios.interceptors.response.use(
    function(response) {
        return response;
    },
    function(error) {
        if (error.response.status === 401) {
            window.location = '/login'
        }
        return Promise.reject(error);
    }
);

export default axios
