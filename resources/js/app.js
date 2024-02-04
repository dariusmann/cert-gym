import './bootstrap';

import { createApp, h } from 'vue';
import { createInertiaApp, router} from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { i18nVue } from 'laravel-vue-i18n';
import VueGtag from "vue-gtag";

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
            .use(ZiggyVue, Ziggy)
            .use(i18nVue, {
                resolve: async lang => {
                    const langs = import.meta.glob('../../lang/*.json');
                    return await langs[`../../lang/${lang}.json`]();
                }
            })
            .use(VueGtag, {
                config: { id: "G-FGWCHXHPB1" }
            })
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
    try {
        rdt('track', 'ViewContent');
    }catch (e) {
        console.log(e)
    }
});
