/**
 * External dependencies.
 */
import { createApp } from "vue";
import { createHooks } from "@wordpress/hooks";

/**
 * Internal dependencies.
 */
import App from "./App.vue";
import router from "./router";
import './i18n';
import "./styles/main.scss";
import i18nMixin from "./mixins/i18n";
import './utils/menu-fix';
import store from "./store";

// Create vue app instance.
const app = createApp({
    extends: App,
    mixins: [i18nMixin]
});

app.use(router)
    .use(store);

app.config.devtools = process.env.NODE_ENV === "development";

// Finally Mount on the #wp-am-vue-app div.
app.mount("#wp-am-vue-app");

// Add action/filter hooks injectable
window.wpAmVueHooks = createHooks();
wpAmVueHooks.addFilter = (hookName, namespace, component, priority = 10) => {
    wpAmVueHooks.hooks.addFilter(
        hookName,
        namespace,
        components => {
            components.push(component);
            return components;
        },
        priority
    );
};
