/// CSS
import '../sass/guest.scss';

/// Vendor
import './vendor';

/// Custom
import './guest/custom';

/// Vue Components
//import ExampleComponent from './guest/components/ExampleComponent.vue';

const app = vueApp({});
//app.component('example-component', ExampleComponent);
app.mount('#app');