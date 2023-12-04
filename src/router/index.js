/**
 * External dependencies.
 */
import { createRouter, createWebHistory } from "vue-router";

/**
 * Internal dependencies.
 */
import Table from "../pages/Table.vue";
import Settings from "../pages/Settings.vue";
import Graph from "../pages/Graph.vue";

const routes = [
    {
        path: "/",
        name: "Settings",
        component: Settings,
        alias: '/settings'
    },
    {
        path: "/table",
        name: "Table",
        component: Table,
    },
    {
        path: "/graph",
        name: "Graph",
        component: Graph
    }
];

const router = createRouter({
    history: createWebHistory(wpAmVue.site.base_url),
    routes
});

export default router;
