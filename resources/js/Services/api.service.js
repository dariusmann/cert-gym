import axios from 'axios'


const apiClient = axios.create({
    baseURL: 'https://af5b6ee3-33c0-4f76-9ecd-2d831784700a.mock.pstmn.io',
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
