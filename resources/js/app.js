/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");
window.Vue = require("vue/dist/vue");
import Buefy from "buefy";

Vue.use(Buefy);

Vue.component("heading", require("./components/layouts/header.vue").default);
