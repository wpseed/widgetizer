import Vue from 'vue'
import VueRouter from 'vue-router'
import Buefy from 'buefy'
import Axios from 'axios'
import VueCodemirror from 'vue-codemirror'
import VueBreadcrumbs from 'vue-2-breadcrumbs';

Vue.use(Buefy);
Vue.use(VueRouter);
Vue.use(VueCodemirror);
Vue.use(VueBreadcrumbs, {
	template: '<nav class="breadcrumb is-medium" aria-label="breadcrumbs" v-if="$breadcrumbs.length">' +
		'<ul>' +
		'<li class="breadcrumb-item" v-if="crumb.meta.breadcrumb" v-for="(crumb, key) in $breadcrumbs">' +
		'<router-link :to="{ path: getPath(crumb) }">{{ getBreadcrumb(crumb.meta.breadcrumb) }}</router-link>' +
		'</li>' +
		'</ul>' +
		'</nav>'
});

window.axios = Axios;
window.axios.defaults.headers.common['X-WP-Nonce'] = dataWpseedWidgetizerAdmin.nonce;

import HomeComponent from "./components/HomeComponent";
import AddWidgetComponent from "./components/AddWidgetComponent";
import AllWidgetsComponent from "./components/AllWidgetsComponent";
import WidgetComponent from "./components/WidgetComponent";
import NotFoundComponent from "./components/NotFoundComponent";

const files = require.context('./components', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

const routes = [
		{ path: '/', redirect: '/home' },
		{
			path: '/home',
			component: HomeComponent,
			meta: {
				breadcrumb: 'Home'
			},
		},
		{
			path: '/add-widget',
			component: AddWidgetComponent,
			meta: {
				breadcrumb: 'Add widget'
			}
		},
		{
			path: '/widgets',
			component: AllWidgetsComponent,
			meta: {
				breadcrumb: 'All Widgets'
			}
		},
		{
			path: '/widgets/:widget_provider/:widget_name',
			component: WidgetComponent,
			meta: {
				breadcrumb: function() { return this.$route.params.widget_name }
			}
		},
		{
			path: '*',
			component: NotFoundComponent
		}
	];
const router = new VueRouter({routes : routes});

const app = new Vue({
	router
}).$mount('#wpseed-widgetizer-admin');
