import axios from 'axios'


const apiClient = axios.create({
    baseURL: 'http://127.0.0.1:8000/',
    withCredentials: false,
    headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
    },
});

const ApiService = {
    get (resource, addConfig) {
        const config = { ...addConfig }
        return apiClient.get(resource, config)
    },

    post (resource, data, addConfig) {
        const config = { withCredentials: true, ...addConfig }
        return apiClient.post(resource, data, config)
    },

    put (resource, data, addConfig) {
        const config = { withCredentials: true, ...addConfig }
        return apiClient.put(resource, data, config)
    },

    delete (resource, addConfig) {
        const config = { withCredentials: true, ...addConfig }
        return apiClient.delete(resource, config)
    },
}

export default ApiService
