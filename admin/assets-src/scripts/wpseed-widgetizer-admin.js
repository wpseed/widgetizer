import Vue from 'vue'
import VueRouter from 'vue-router'
import Buefy from 'buefy'
import Axios from 'axios'
import VueCodemirror from 'vue-codemirror'

Vue.use(Buefy);
Vue.use(VueRouter);
Vue.use(VueCodemirror);

window.axios = Axios;
window.axios.defaults.headers.common['X-WP-Nonce'] = dataWpseedWidgetizerAdmin.nonce;

import HomeComponent from "./components/HomeComponent";
import WidgetComponent from "./components/WidgetComponent";

const files = require.context('./components', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

const routes = [
		{ path: '/', redirect: '/home' },
		{ path: '/home', component: HomeComponent },
		{ path: '/widget/:widget_provider/:widget_name', component: WidgetComponent },
	];
const router = new VueRouter({routes : routes});

const app = new Vue({
	router
}).$mount('#wpseed-widgetizer-admin');
