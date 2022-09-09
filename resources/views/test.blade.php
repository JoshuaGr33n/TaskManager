<!-- <div id="app">
<router-link_to="/">/home</router-link>
<router-link_to="/foo"></router-link>
<router-view></router-view>
</div>
<script src="https://npmcdn.com/vue/dist/vue.js"></script>
<script src="https://npmcdn.com/vue-router/dist/vue-router.js"></script>
<script>
const Home = { template: "<div>Home</div>" };
const Foo = { template: "<div>Foo</div>" };
const router = new VueRouter({
mode: "history",
routes: [
{ path: "/", component: Home },
{ path: "/foo", component: Foo },
],
});
new Vue({
router,
el: "#app",
watch: {
$route: {
},
immediate: true,
handler (to) {
console.log("path", to.path);
},
},
});
</script> -->


<div id="app">
<message></message>
<message val></message>
<message val=""></message>
<message :val="null"></message>
<message
:val="true"></message>
<message val="null"></message>
<message
val="true"></message>
<message :val="0"></message>
<message
val="zero"></message>
<message :val="undefined"></message>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<script>
Vue.component('message', {
props: ['val'],
template: '<span>{{val}}</span>'
});
const app = new Vue({
el: '#app'
});
</script>