require('./bootstrap');
import { Form, HasError, AlertError } from 'vform';
import draggable from 'vuedraggable'
window.Vue = require('vue');
window.Form = Form;

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component(draggable.name, draggable)

Vue.component('projects-component', require('./components/ProjectsComponent.vue').default);
Vue.component('task-component', require('./components/TaskComponent.vue').default);

const app = new Vue({
    el: '#app',
});
