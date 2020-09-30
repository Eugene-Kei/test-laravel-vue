import axios from '../axios'

export default {
    async getStatistics () {
        return axios.get('/statistics')
    },
}
