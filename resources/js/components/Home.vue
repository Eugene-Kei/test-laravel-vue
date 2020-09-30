<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <nav class="nav">
                    <router-link class="nav-link" :to="{name: 'tasks'}">Tasks</router-link>
                    <router-link class="nav-link" :to="{name: 'statistics'}">Statistics</router-link>
                </nav>
            </div>
            <div class="col-md-8 mt-3">
                <router-view :current-user="currentUser"/>
            </div>
        </div>
    </div>
</template>

<script>
import users from '../axios/requests/users'

export default {
    data: () => ({
        currentUser: null
    }),
    mounted () {
        this.getCurrentUser()
    },
    methods: {
        getCurrentUser () {
            users.getUserInfo().then((response) => {
                this.currentUser = response.data.data
            })
        }
    }
}
</script>

<style scoped>
.router-link-exact-active {
    border-bottom: #1d68a7 2px solid;
    border-bottom-width: thin;
}
</style>
