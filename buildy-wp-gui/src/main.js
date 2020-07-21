/*eslint no-undef: 0*/
import Vue from 'vue'
import App from './App.vue'
import store from './store'
import 'prismjs'
import 'prismjs/themes/prism.css'

Vue.config.productionTip = false

import '@/assets/css/tailwind.css'

import VModal from 'vue-js-modal'
Vue.use(VModal)

const files = require.context('./components', true, /\.vue$/i)
const validComponents = []
files.keys().map(key => {
    let name = key.split('/').pop().split('.')[0];

    // Save registered components names
    validComponents.push(files(key).default.name)

    Vue.component(name, files(key).default)
})

let config = '';

if (document.getElementById('config')) {
    const configElement = document.getElementById('config');
    config = configElement.innerHTML;
}

let content;
if (document.getElementById('content') && document.getElementById('content').value) {
    content = JSON.parse(document.getElementById('content').value)
}

new Vue({
    store,
    render: h => h(App, { props: { config: config || [], content: content, validComponents: validComponents } })
}).$mount('#app')
