import axios from '../axios'

export default {
    async getUserInfo () {
        return axios.get('/user-info')
    },
}
