Nova.booting((Vue, router, store) => {
  Vue.component('index-nova-radio-field', require('./components/IndexField'))
  Vue.component('detail-nova-radio-field', require('./components/DetailField'))
  Vue.component('form-nova-radio-field', require('./components/FormField'))
})
