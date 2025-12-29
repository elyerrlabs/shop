import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { $notify } from "@shop/config/notify.js";
import { $server } from "@shop/config/axios.js";
import { setupI18n, __ } from "@shop/config/locale.js";

setupI18n();
window.__ = __;

createInertiaApp({
  resolve: (name) => require(`./pages/${name}.vue`).default,
  setup({ el, App, props, plugin }) {

    const app = createApp({ render: () => h(App, props) });

    app.config.globalProperties.$server = $server;
    app.config.globalProperties.$notify = $notify;
    app.config.globalProperties.__ = __;

    app.use(plugin);
    app.mount(el);
  },
});
