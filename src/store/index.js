/**
 * External dependencies.
 */
import { createStore, createLogger } from "vuex";
import settings from "./modules/settings";
import global from "./modules/global";
import graph from "./modules/graph";
import table from "./modules/table";

const debug = process.env.NODE_ENV !== "production";

const store = createStore({
    modules: {
        global,
        settings,
        graph,
        table,
    },
    strict: debug,
    plugins: debug ? [createLogger()] : []
});

export default store;
