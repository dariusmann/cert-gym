import './bootstrap';

import { createApp, h } from 'vue';
import { createInertiaApp, router} from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { i18nVue } from 'laravel-vue-i18n';
import VueGtag from "vue-gtag";
import PrimeVue from 'primevue/config';
import VueApexCharts from "vue3-apexcharts";
import ConfirmationService from 'primevue/confirmationservice';

import 'primevue/resources/themes/lara-light-green/theme.css';
import 'primevue/resources/primevue.min.css';
import '@fortawesome/fontawesome-free/css/all.min.css';

import.meta.glob([
    '../images/**',
]);

const appName = import.meta.env.VITE_APP_NAME || 'Cert Gym';


createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(PrimeVue)
            .use(ZiggyVue, Ziggy)
            .use(ConfirmationService)
            .use(i18nVue, {
                resolve: async lang => {
                    const langs = import.meta.glob('../../lang/*.json');
                    return await langs[`../../lang/${lang}.json`]();
                }
            })
            .use(VueGtag, {
                config: { id: "G-FGWCHXHPB1" }
            })
            .use(VueApexCharts)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

router.on('navigate', (event) => {
    gtag('event', 'page_view', {
        'page_location': event.detail.page.url
    });
});
