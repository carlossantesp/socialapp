/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");

window.EventBus = new Vue();

Vue.component(
    "status-form",
    require("./components/StatusFormComponent.vue").default
);
Vue.component(
    "status-list",
    require("./components/StatusListComponent.vue").default
);
Vue.component(
    "friendship-btn",
    require("./components/FriendshipBtn.vue").default
);

Vue.component(
    "accept-friendship-btn",
    require("./components/AcceptFriendshipBtn.vue").default
);

Vue.component(
    "notification-list",
    require("./components/NotificationList.vue").default
);

Vue.component(
    "status-list-item",
    require("./components/StatusListItem.vue").default
);

import auth from "./mixins/auth";
Vue.mixin(auth);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app"
});
