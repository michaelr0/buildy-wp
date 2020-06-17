<template>
    <div class="module module-settings">
      <span v-if="header" class="text-2xl block mb-4" v-text="header" />     
      <textarea class="w-full h-24 p-4" v-model="value" @blur="change"></textarea>
    </div>
</template>
<script>
import { setDeep, getDeep } from '../../functions/objectHelpers';

// @ts-ignore
export default {
  name: 'code-editor',
    data: function() {
      return {
        value: '',
      }
    }, 
    props: {
      path: String,
      header: String,
    },
    methods: {
      change() {
        setDeep(this.component, this.path, this.value)
        this.$emit('change', {data: this.value, path: this.path})
      },
    },
    mounted() {
      this.value = getDeep(this.component, this.path) || ''
    },
    inject: ['component']
}
</script>
