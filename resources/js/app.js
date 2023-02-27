import WaveUI from "wave-ui";
import "wave-ui/dist/wave-ui.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { Head } from '@inertiajs/vue3';
import  {Link} from '@inertiajs/vue3';


import SkDialog from "./components/SkDialog.vue";
import SksuLink from "./components/SksuLink.vue";
import Loader1 from "./components/Loader1.vue";
import SkButton from "./components/SkButton.vue";
import SkButton2 from "./components/SkButton2.vue";
import SkButton3 from "./components/SkButton3.vue";
import SkDeleteButton from "./components/SkDeleteButton.vue";
import SkButtonGray from "./components/SkButtonGray.vue";
import Authfield from "./components/Authfield.vue";
import Authfield1 from "./components/Authfield1.vue";
import SksuProfile from "./components/SksuProfile.vue";
import SkTable from "./components/SkTable.vue";
import Tcell from "./components/Tcell.vue";
import SkCheckbox from "./components/SkCheckbox.vue";
import DashboardLink from "./components/DashboardLink.vue";
import TableTitle from "./components/TableTitle.vue";
import Pagination from "./components/Pagination.vue";
import EmptyCard from "./components/EmptyCard.vue";
import Notification from "./components/Notification.vue";
import AccountLink from "./components/AccountLink.vue";
import StatusCard from "./components/StatusCard.vue";
import approveSvg from "./components/approveSvg.vue";
import deniedSvg from "./components/deniedSvg.vue";
import checkedSvg from "./components/checkedSvg.vue";
import fileSvg from "./components/fileSvg.vue";
import timeSvg from "./components/timeSvg.vue";
import roundedCheckSvg from "./components/roundedCheckSvg.vue";
import FileCard from "./components/FileCard.vue";
import FilePondBase from "./components/FilePondBase.vue";
import FileUpload from "./components/FileUpload.vue";
import FileViewLink from "./components/FileViewLink.vue";
import thumbsUpSvg from "./components/thumbsUpSvg.vue";
import NotificationList from "./components/NotificationList.vue";
import thumbsDownSvg from "./components/thumbsDownSvg.vue";
import Datepicker from 'vue3-datepicker';


createInertiaApp({

    progress: {
        color: '#ffff',
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
            .component("SkTable", SkTable)
            .component("Tcell", Tcell)
            .component("SkCheckbox", SkCheckbox)
            .component("Datepicker", Datepicker)
            .component("Head", Head)
            .component("Pagination", Pagination)
            .component("Link", Link)
            .component("EmptyCard", EmptyCard)
            .component("AccountLink", AccountLink)
            .component("TableTitle", TableTitle)
            .component("Notification", Notification)
            .component("approveSvg", approveSvg)
            .component("deniedSvg", deniedSvg)
            .component("checkedSvg", checkedSvg)
            .component("fileSvg", fileSvg)
            .component("roundedCheckSvg", roundedCheckSvg)
            .component("timeSvg", timeSvg)
            .component("thumbsUpSvg", thumbsUpSvg)
            .component("thumbsDownSvg", thumbsDownSvg)
            .component("StatusCard", StatusCard)
            .component("FileCard", FileCard)
            .component("FilePondBase", FilePondBase)
            .component("FileUpload", FileUpload)
            .component("FileViewLink", FileViewLink)
            .component("NotificationList", NotificationList)
            .component("DashboardLink", DashboardLink);

        return app.mount(el);
    },
});
