import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import axios from "axios";
import AdminLayout from "@/Shared/AdminLayout";
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

// Axios for Laravel use
window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

createInertiaApp({
    resolve: (name) => {
        const page = require(`./Pages/${name}`).default;
        page.layout = AdminLayout;

        return page;
    },
    setup({ el, app, props, plugin }) {
        createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(Toast, {})
            .mixin({ methods: { route } })
            .mount(el);
    },
});
