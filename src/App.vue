<template>
  <div id="wp-am-vue-app">
    <div v-if="showNotice" class="wp-am-notice-bar">
      <div class="wp-am-notice-bar-container">
        <span class="wp-am-notice-bar-message" v-html="noticeMessage"></span>
        <button type="button" class="dismiss" title="Dismiss this message." @click="dismissNotice"></button>
      </div>
      </div>
    <div class="main-content">
      <div class="wp-am-header">
        <h1>{{ __('WP AM Vue App', 'wp-am-vue-app') }}</h1>
        <p>{{ __('Vue JS based admin page') }}</p>
      </div>
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
    data() {
    return {
      proUpgradeLink: 'https://example.com/upgrade',
      showNotice: true
    };
  },
  computed: {
    noticeMessage() {
      return sprintf('You’re using WP Am Lite. To unlock more features, consider <a href="%s">upgrading to Pro</a>.', this.proUpgradeLink);
    }
  },
  created() {
    const lastDismissed = localStorage.getItem('wpAmNoticeDismissed');
    if (lastDismissed && (Date.now() - lastDismissed < 86400000)) {
      this.showNotice = false;
    }
  },
  methods: {
    dismissNotice() {
      this.showNotice = false;
      localStorage.setItem('wpAmNoticeDismissed', Date.now());
    }
  },
    watch: {
        $route() {
            menuFix();
        }
    }
};
</script>
<style lang="scss">
.wp-am-notice-bar{
    max-height: 35px;
    position: relative;
    margin-bottom: -3px;
    transition: all .3s ease-out;
    overflow: hidden;

    .wp-am-notice-bar-container{
      background-color: #ddd;
      border-top: 3px solid #e27730;
      color: #50575e;
      text-align: center;
      padding: 7px;
        a{
            color: #e27730;
            text-decoration: underline;
            &:hover{
                color: #b85a1b;
            }
        }
        .dismiss{
          position: absolute;
          top: 0;
          right: 0;
          border: none;
          padding: 5px;
          margin-top: 4px;
          background: 0 0;
          color: #72777c;
          cursor: pointer;
          &:before {
            content: '\f335';
            font-family: 'dashicons';
            font-size: 20px;

          }
        }
    }

}
.wp-am-header {
    background: #f1f1f1;
    padding: 30px 20px;
    border-bottom: 1px solid #eaeaea;

    h1 {
        margin-bottom: 20px;
        font-size: 40px;
    }
    p {
        margin: 0;
        font-size: 20px;
    }
}

</style>