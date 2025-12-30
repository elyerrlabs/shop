

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { setupI18n, __ } from "@shop/config/locale.js";
import { $notify } from "@shop/config/notify.js";
import "@shop/config/editor.js";
import VueSweetalert2 from "vue-sweetalert2";
import { $server } from "@shop/config/axios.js";

setupI18n();
window.__ = __;
window.$server = $server;
window.$notify = $notify;

createInertiaApp({
  resolve: (name) => require(`./pages/${name}.vue`).default,
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) });

    // app.config.globalProperties.$echo = $echo;
    app.config.globalProperties.$server = $server;
    app.config.globalProperties.$notify = $notify;
    app.config.globalProperties.__ = __;

    app.use(VueSweetalert2);
    app.use(plugin);
    app.mount(el);
  },
});
