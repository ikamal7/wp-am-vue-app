import axios from 'axios';

const state = {
    tableHeaders: [],
    tableRows: [],
};

const mutations = {
    SET_TABLE_HEADERS(state, headers) {
        state.tableHeaders = headers;
    },
    SET_TABLE_ROWS(state, rows) {
        state.tableRows = rows;
    },
};

const actions = {
    getTableData({ commit, rootGetters }) {
        const settings = rootGetters['settings'];

        if (!settings) {
            console.error('Settings not found');
            return;
        }

        axios.get(`${wpAmVue.site.rest_base}/wp-am-vue-app/v1/data`)
            .then(response => {
                const data = response.data.table.data;
                const headers = data.headers;
                const rows = data.rows.map(row => ({
                    id: row.id,
                    url: row.url,
                    title: row.title,
                    pageviews: row.pageviews,
                    date: settings.readable === 1 ? new Date(row.date * 1000).toLocaleString() : row.date,
                }));

                const slicedRows = rows.slice(0, settings.rows);

                commit('SET_TABLE_HEADERS', headers);
                commit('SET_TABLE_ROWS', slicedRows);
            })
            .catch(error => {
                console.error('Error fetching table data:', error);
            });
    },
};

const getters = {
    getTableHeaders: state => state.tableHeaders,
    getTableRows: state => state.tableRows,
};

export default {
    state,
    mutations,
    actions,
    getters,
};
