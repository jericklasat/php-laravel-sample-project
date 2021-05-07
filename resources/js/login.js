import Vue from "vue";
import Buefy from "buefy";
require("./bootstrap");
Vue.use(Buefy);

import login from "./components/login";

const app = new Vue({
    el: "#app",
    components: {
        login
    }
});
