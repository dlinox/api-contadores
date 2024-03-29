import "./bootstrap";
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { createPinia } from 'pinia'

import vuetify from "./plugins/vuetify";

import '@vuepic/vue-datepicker/dist/main.css'
import "vue-advanced-cropper/dist/style.css";

const pinia = createPinia()

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(vuetify)
            .use(pinia)
            .mount(el);
    },
});
