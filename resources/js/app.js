import WaveUI from "wave-ui";
import "wave-ui/dist/wave-ui.css";

import layout from "./layouts/layout.vue";
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";

import SkDialog from "./componets/SkDialog.vue";
import SksuLink from "./componets/SksuLink.vue";
import Loader1 from "./componets/Loader1.vue";
import SkButton from "./componets/SkButton.vue";
import Authfield from "./componets/Authfield.vue";
import Authfield1 from "./componets/Authfield1.vue";
import SksuProfile from "./componets/SksuProfile.vue";
import DashboardLink from "./componets/DashboardLink.vue";

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
        .mixin({methods: {route}})
            .use(WaveUI)
            .use(plugin)
            .component("SkDialog", SkDialog)
            .component("Loader1", Loader1)
            .component("SksuLink", SksuLink)
            .component("Authfield", Authfield)
            .component("Authfield1", Authfield1)
            .component("SkButton",SkButton)
            .component("SksuProfile", SksuProfile)
            .component("DashboardLink", DashboardLink);

        return app.mount(el);
    },
});
