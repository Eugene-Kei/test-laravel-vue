import axios from '../axios'

export default {
    async getTasks (status) {
        return axios.get('/tasks', { params: { status } })
    },

    async createTask (attributes) {
        return axios.post('/tasks', attributes)
    },

    async updateTask (taskId, attributes) {
        return axios.put('/tasks/' + taskId, attributes)
    },

    async changeTaskStatus (taskId, status) {
        return axios.put(`/tasks/${taskId}/change-status`, { status })
    },

    async deleteTask (taskId) {
        return axios.delete('/tasks/' + taskId)
    }
}
