<template>
  <div class="graph-page">
    <h4>Graph Page</h4>
    <BarChart
      :labels="graphData.labels"
      :datasets="graphData.datasets"
      :height="100"
    />
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import BarChart from '../components/chart/BarChart.vue';

export default {
    name: 'Graph',
    components: { BarChart },

    computed: {
        ...mapGetters(['getGraphData']),
        graphData() {
            return {
                labels: this.getGraphData.labels,
                datasets: [
                    {
                        label: 'Values',
                        backgroundColor: 'rgba(75, 192, 192, 1)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 5,
                        data: this.getGraphData.values,
                    },
                ],
            };
        },
    },

    created() {
    // Dispatch the fetchGraphData action when the component is created
        this.fetchGraphData();
    },

    methods: {
        ...mapActions(['fetchGraphData']),
    },
};
</script>
