import WaveUI from "wave-ui";
import "wave-ui/dist/wave-ui.css";

import layout from "./layouts/layout.vue";
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { Head } from "@inertiajs/vue3";
import  {Link} from '@inertiajs/vue3';



import SkDialog from "./componets/SkDialog.vue";
import SksuLink from "./componets/SksuLink.vue";
import Loader1 from "./componets/Loader1.vue";
import SkButton from "./componets/SkButton.vue";
import SkButton2 from "./componets/SkButton2.vue";
import SkButton3 from "./componets/SkButton3.vue";
import SkDeleteButton from "./componets/SkDeleteButton.vue";
import SkButtonGray from "./componets/SkButtonGray.vue";
import Authfield from "./componets/Authfield.vue";
import Authfield1 from "./componets/Authfield1.vue";
import SksuProfile from "./componets/SksuProfile.vue";
import DashboardLink from "./componets/DashboardLink.vue";
import Pagination from "./componets/Pagination.vue";
import Datepicker from 'vue3-datepicker';


createInertiaApp({

    progress: {
        color: '#12af51',
    },
    resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ 
     
        render: () => h(App, props) })
        .mixin({methods: {route}})
            .use(WaveUI)
            .use(plugin)
            .component("SkDialog", SkDialog)
            .component("Loader1", Loader1)
            .component("SksuLink", SksuLink)
            .component("Authfield", Authfield)
            .component("Authfield1", Authfield1)
            .component("SkButton",SkButton)
            .component("SkButton2",SkButton2)
            .component("SkButton3",SkButton3)
            .component("SkDeleteButton",SkDeleteButton)
            .component("SkButtonGray",SkButtonGray)
            .component("SksuProfile", SksuProfile)
            .component("Datepicker", Datepicker)
            .component("Head", Head)
            .component("Pagination", Pagination)
            .component("Link", Link)
            .component("DashboardLink", DashboardLink);

        return app.mount(el);
    },
});
