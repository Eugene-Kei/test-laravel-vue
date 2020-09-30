<template>
    <div>
        <div class="row">
            <span class="col h3">Tasks</span>
            <span class="col text-right">
            <button
                id="modal-form-open-button"
                type="button"
                class="btn btn-success btn-sm"
                data-toggle="modal" data-target="#form-modal"
            >Create task</button>
        </span>
        </div>
        <task-nav :status="status" @change-nav-status="changeNavStatus"/>
        <div v-if="isLoading">
            <spinner/>
        </div>
        <div v-else-if="tasks.length > 0">
            <div class="row justify-content-center">
                <div class="mt-2 col-12" v-for="task of tasks">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ task.name }}</h5>
                            <h6 class="card-subtitle mb-2 font-weight-bold" :class="getStatusColor(task.status)">
                                {{ getStatusText(task.status) }}
                            </h6>
                            <div class="card-text">
                                Created: {{ task.creator.name }} {{ task.created_at }}
                            </div>
                            <div class="card-text" v-if="task.executor">
                                Executor: {{ task.executor.name }}
                            </div>
                            <div class="card-text">
                                Cost: {{ task.price }} $
                            </div>
                            <div class="card-text mt-2">
                                {{ task.description }}
                            </div>
                            <button
                                v-if="task.status === 1"
                                type="button"
                                class="btn btn-link btn-sm"
                                @click="taskToJob(task)"
                            >Take to work
                            </button>
                            <button
                                v-if="task.status === 2 && isSelfExecutor(task.executor)"
                                type="button"
                                class="btn btn-link btn-sm"
                                @click="isCurrentUserIsAdmin() ? taskToCompleted(task) : taskToCheck(task)"
                            >
                                Complete task
                            </button>
                            <button
                                v-if="task.status === 3 && isCurrentUserIsAdmin()"
                                type="button"
                                class="btn btn-link btn-sm"
                                @click="taskToCompleted(task)"
                            >To accept
                            </button>
                            <button
                                v-if="task.status === 3 && isCurrentUserIsAdmin()"
                                type="button"
                                class="btn btn-link btn-sm"
                                @click="taskToJob(task)"
                            >Reject
                            </button>
                            <button
                                v-if="task.status === 1 && isCurrentUserIsAdmin()"
                                type="button"
                                class="btn btn-link btn-sm"
                                :disabled="isDeletingTask"
                                @click="openFormToUpdate(task)"
                            >Update
                            </button>
                            <button
                                v-if="task.status === 1 && isCurrentUserIsAdmin()"
                                type="button"
                                class="btn btn-link btn-sm"
                                :disabled="isDeletingTask"
                                @click="deleteTask(task.id)"
                            >Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <div class="row justify-content-center">
                <div class="mt-2 col-12">
                    <div class="alert alert-secondary">
                        No tasks found
                    </div>
                </div>
            </div>
        </div>
        <div id="form-modal" class="modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create task</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="task-name">Name</label>
                            <input
                                type="text"
                                class="form-control"
                                :class="{'is-invalid': validationErrors['name']}"
                                id="task-name"
                                v-model="taskModel.name"
                                @input="deleteValidationErrorByName('name')"
                            >
                            <div class="invalid-feedback" v-if="validationErrors['name']">
                                {{ validationErrors['name'][0] }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="task-description">Description</label>
                            <textarea
                                class="form-control"
                                :class="{'is-invalid': validationErrors['description']}"
                                id="task-description"
                                rows="3"
                                v-model="taskModel.description"
                                @input="deleteValidationErrorByName('description')"
                            ></textarea>
                            <div class="invalid-feedback" v-if="validationErrors['description']">
                                {{ validationErrors['description'][0] }}
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="task-price">Price</label>
                            <input
                                type="text"
                                class="form-control"
                                :class="{'is-invalid': validationErrors['price']}"
                                id="task-price"
                                v-model="taskModel.price"
                                @input="deleteValidationErrorByName('price')"
                            >
                            <div class="invalid-feedback" v-if="validationErrors['price']">
                                {{ validationErrors['price'][0] }}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <span id="modal-form-close-button" class="d-none" data-dismiss="modal">Close</span>
                        <button type="button" class="btn btn-link" @click="closeFormModal">Close</button>
                        <button
                            type="button"
                            class="btn btn-link"
                            :disabled="isSendingForm"
                            @click="sendForm"
                        >Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import tasks from '../axios/requests/tasks'
import TaskNav from './TaskNav'
import Spinner from './Spinner'

export default {
    name: 'Tasks',
    props: ['currentUser'],
    components: { TaskNav, Spinner },
    data: () => ({
        taskModel: {},
        isLoading: false,
        isDeletingTask: false,
        isSendingForm: false,
        tasks: [],
        validationErrors: {},
        status: '',
        statusTexts: {
            1: 'New',
            2: 'In work',
            3: 'On check',
            4: 'Completed',
        },
        statusColors: {
            1: 'text-success',
            2: 'text-info',
            3: 'text-danger',
            4: 'text-muted',
        },
    }),
    mounted () {
        this.getTasks()
    },
    methods: {
        getTasks () {
            this.isLoading = true
            tasks.getTasks(this.status).then((response) => {
                if (response.data?.data) {
                    this.tasks = response.data.data
                }
            }).catch((error) => {
                alert(error.response?.data)
            }).finally(() => {
                this.isLoading = false
            })
        },
        getStatusText (status) {
            return this.statusTexts[status]
        },
        getStatusColor (status) {
            return this.statusColors[status]
        },
        changeNavStatus (status) {
            this.status = status
            this.getTasks()
        },
        isSelfExecutor (executor) {
            return this.currentUser?.id === executor.id
        },
        isCurrentUserIsAdmin () {
            return this.currentUser?.is_admin === 1
        },
        taskToJob (task) {
            this.changeTaskStatus(task, 2)
        },
        changeTaskStatus (task, status) {
            tasks.changeTaskStatus(task.id, status).then((response) => {
                this.getTasks()
            }).catch((error) => {
                alert(error.response?.data)
            })
        },
        taskToCheck (task) {
            this.changeTaskStatus(task, 3)
        },
        taskToCompleted (task) {
            this.changeTaskStatus(task, 4)
        },
        deleteTask (taskId) {
            this.isDeletingTask = true
            tasks.deleteTask(taskId).then((response) => {
                if (response.status === 204) {
                    this.getTasks()
                }
            }).catch((error) => {
                alert(error.response?.data)
            }).finally(() => {
                this.isDeletingTask = false
            })
        },
        openFormToUpdate(task) {
            this.taskModel = {...task}
            this.openFormModal()
        },
        openFormModal () {
            document.getElementById('modal-form-open-button').click()
        },
        closeFormModal () {
            this.taskModel = {}
            document.getElementById('modal-form-close-button').click()
        },
        sendForm () {
            this.isSendingForm = true
            let promise
            if (this.taskModel?.id) {
                promise = tasks.updateTask(this.taskModel.id, this.taskModel).then((response) => {
                    if (response.status === 200) {
                        this.getTasks()
                        this.closeFormModal()
                        this.taskModel = {}
                    }
                })
            } else {
                promise = tasks.createTask(this.taskModel).then((response) => {
                    if (response.status === 201) {
                        this.getTasks()
                        this.closeFormModal()
                        this.taskModel = {}
                    }
                })
            }
            promise.catch((error) => {
                if (error.response?.status === 422) {
                    this.validationErrors = error.response?.data?.errors
                } else {
                    alert(error.response?.data)
                }
            }).finally(() => {
                this.isSendingForm = false
            })
        },
        deleteValidationErrorByName(errorName) {
            if (this.validationErrors[errorName]) {
                delete this.validationErrors[errorName]
            }
        }
    }
}
</script>

