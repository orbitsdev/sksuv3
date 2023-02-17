import WaveUI from "wave-ui";
import "wave-ui/dist/wave-ui.css";

import layout from "./layouts/layout.vue";
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";

import SkDialog from "./componets/SkDialog.vue";

createInertiaApp({
    async resolve(name) {
        const page = await resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob("./pages/**/*.vue")
        );
        if (!page.default.layout) {
            page.default.layout = layout;
        }

        return page;
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(WaveUI)
            .use(plugin)
            .component("SkDialog", SkDialog);

        return app.mount(el);
    },
});
