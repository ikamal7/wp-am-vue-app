/**
 * External dependencies.
 */
import axios from 'axios';

// initial state
const state = () => ({
    settings: null,
    isSaving: false,
});

// getters
const getters = {
    settings: state => state.settings,
    isSaving: state => state.isSaving,
};

// actions
const actions = {
    async storeSettings({ commit }, settings) {
      try {
        commit('setSettingsSaving', true);
  
        // Make a POST request to the specified endpoint
          const response = await axios.post(`${ wpAmVue.site.rest_base }/wp-am-vue-app/v1/settings`,
              settings,
              {
                headers: {
                  'X-WP-Nonce':`${ wpAmVue.site.nonce }`,
                  'content-type': 'application/json',
                },
              }
          );
  
        // Assuming the server returns the updated settings
        commit('storeSettings', response.data);
        commit('setSettingsSaving', false);
        
      } catch (error) {
        console.error('Error while saving settings:', error);
        commit('setSettingsSaving', false);
      }
  },
  
  async getSettings({ commit }) {
    try {
      // Make a GET request to the specified endpoint
      const response = await axios.get(`${wpAmVue.site.rest_base}/wp-am-vue-app/v1/settings`);

      // Assuming the server returns the settings data
      commit('storeSettings', response.data);
    } catch (error) {
      console.error('Error while fetching settings:', error);
    }
  },
  };

// mutations
const mutations = {
    storeSettings: (state, settings) => {
        state.settings = settings;
    },

    setSettingsSaving: (state, isSaving) => {
        state.isSaving = isSaving;
    },
};

export default {
    state,
    getters,
    actions,
    mutations
};