import axios from 'axios';

const state = {
    graphData: {
        labels: [],
        values: [],
    },
};

const mutations = {
    SET_GRAPH_DATA(state, newData) {
    // Clear existing data
        state.graphData.labels = [];
        state.graphData.values = [];

        // Push new data
        state.graphData.labels.push(...newData.labels);
        state.graphData.values.push(...newData.values);

    },
};

const actions = {
    fetchGraphData({ commit }) {
        axios.get(`${wpAmVue.site.rest_base}/wp-am-vue-app/v1/data`)
            .then(response => {
                const data = response.data.graph;


                // temporary variables
                const labels = [];
                const values = [];

                Object.values(data).forEach((item) => {
                    const date = new Date(item.date * 1000);
                    labels.push(date.toLocaleString('default', { month: 'long' }));
                    values.push(item.value);
                });

                const graphData = {
                    labels,
                    values,
                };

                // Commit the data to graphData
                commit('SET_GRAPH_DATA', graphData);

            })
            .catch(error => {
                console.error('Error fetching data in:', error);
            });
    },
};

const getters = {
    getGraphData: (state) => state.graphData,
};

export default {
    state,
    mutations,
    actions,
    getters,
};
