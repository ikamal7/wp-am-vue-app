<template>
  <div id="wp-am-vue-app">
    <div class="main-content">
      <h3>{{ __('WP AM Vue App', 'wp-am-vue-app') }}</h3>
      <tabs />
      <router-view />
    </div>
  </div>
</template>

<script>
import Tabs from './components/tabs/Tabs.vue';
import { menuFix } from './utils/menu-fix';

export default {
    name: 'App',
    components: {
        Tabs
    },
    watch: {
        $route() {
            menuFix();
        }
    }
};
</script>