<template>
    <div class="mt-2 col-12">
        <nav class="nav nav-tabs">
            <a class="nav-link" :class="getNavIsActiveClass('')" @click="changeNavStatus('')">All</a>
            <a class="nav-link" :class="getNavIsActiveClass('1')" @click="changeNavStatus('1')">New</a>
            <a class="nav-link" :class="getNavIsActiveClass('2')" @click="changeNavStatus('2')">In work</a>
            <a class="nav-link" :class="getNavIsActiveClass('3')" @click="changeNavStatus('3')">On check</a>
            <a class="nav-link" :class="getNavIsActiveClass('4')" @click="changeNavStatus('4')">Completed</a>
        </nav>
    </div>
</template>

<script>
export default {
    name: 'TaskNav',
    props: ['status'],
    methods: {
        getNavIsActiveClass (linkType) {
            return this.status === linkType ? 'active' : ''
        },
        changeNavStatus (status) {
            this.$emit('change-nav-status', status)
        },
    }
}
</script>
