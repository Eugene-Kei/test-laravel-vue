<template>
    <div>
        <h3 class="col-12">Statistics</h3>
        <div v-if="items.length > 0">
            <div class="card mt-2">
                <div class="card-body">
                    <h5 class="card-title">Maximum cost of tasks performed by the user</h5>
                    <div class="progress height-35 mt-2" v-for="item of items">
                        <div class="progress-bar"
                             role="progressbar"
                             :style="{width: `${getPercentOfMaxTaskPrice(item.max_price)}%`}"
                        >
                            {{ item.name }} {{ item.max_price }} $
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-2">
                <div class="card-body">
                    <h5 class="card-title">Minimum cost of tasks performed by the user</h5>
                    <div class="progress height-35 mt-2" v-for="item of items">
                        <div class="progress-bar"
                             role="progressbar"
                             :style="{width: `${getPercentOfMaxMinimalTaskPrice(item.min_price)}%`}"
                        >
                            {{ item.name }} {{ item.min_price }} $
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-2">
                <div class="card-body">
                    <h5 class="card-title">Average cost of tasks performed by the user</h5>
                    <div class="progress height-35 mt-2" v-for="item of items">
                        <div class="progress-bar"
                             role="progressbar"
                             :style="{width: `${getPercentOfMaxAverageTaskPrice(item.avg_price)}%`}"
                        >
                            {{ item.name }} {{ item.avg_price }} $
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else-if="isLoading">
            <spinner/>
        </div>
        <div v-else>
            <div class="row justify-content-center">
                <div class="mt-2 col-12">
                    <div class="alert alert-secondary">
                        Insufficient data to collect statistics.
                        Please complete several tasks.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import statistics from '../axios/requests/statistics'
import Spinner from './Spinner'

export default {
    name: 'Statistics',
    components: { Spinner },
    data: () => ({
        items: [],
        isLoading: false,
        averagePrices: [],
        maxPrices: [],
        minPrices: [],
    }),
    computed: {
        maxTaskPrice () {
            return Math.max(...this.maxPrices)
        },
        maxAverageTaskPrice () {
            return Math.max(...this.averagePrices)
        },
        maxMinimalTaskPrice () {
            return Math.max(...this.minPrices)
        },
    },
    mounted () {
        this.getStatistics()
    },
    methods: {
        getStatistics () {
            this.isLoading = true
            statistics.getStatistics().then((response) => {
                if (response.data?.data) {
                    this.maxPrices = response.data.data.map(({ max_price }) => max_price)
                    this.minPrices = response.data.data.map(({ min_price }) => min_price)
                    this.averagePrices = response.data.data.map(({ avg_price }) => avg_price)
                    this.items = response.data.data
                }
            }).catch((error) => {
                alert('Failed to get data')
            }).finally(() => {
                this.isLoading = false
            })
        },
        getPercentOfMaxTaskPrice (sum) {
            return sum / this.maxTaskPrice * 100
        },
        getPercentOfMaxMinimalTaskPrice (sum) {
            return sum / this.maxMinimalTaskPrice * 100
        },
        getPercentOfMaxAverageTaskPrice (sum) {
            return sum / this.maxAverageTaskPrice * 100
        },
    }
}
</script>

<style scoped>
.height-35 {
    height: 35px;
}
</style>
