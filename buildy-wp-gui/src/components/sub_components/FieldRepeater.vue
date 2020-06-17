<template>
    <div class="field-repeater module module-settings mt-0 flex flex-col">
      <div v-for="(att, index) in value" :key="`${component.id}-${att.att}-${index}`" class="field-repeater__field flex flex-col">
        <label class="pr-4 setting-label">{{ formatLabel(att) }}:</label>
        <div class="flex -mx-2 items-center justify-between">
          <div class="w-1/2 px-2">
            <input class="bg-gray-300 p-2 w-full" @change="handleChange" v-model="att.name" placeholder="Name" />
          </div>
          <div class="w-1/2 px-2">
            <input class="bg-gray-300 p-2 w-full" @change="handleChange" v-model="att.value" placeholder="Value" />
          </div>
        </div>
      </div>
      <a class="text-gray-800 self-end py-2" @click.prevent="addDataAtt" href="#">{{ !value.length ? 'Add data attributes' : 'Add more' }}</a>
    </div>
</template>

<script>
import { setDeep, getDeep } from '../../functions/objectHelpers';
export default {   
  name: 'field-repeater',
  data: function() {
    return {
      value: [],
    }
  }, 
  methods: {
    handleChange() {
      // Helper function to set values at any depth and bore a path to them if undefined
      setDeep(this.component, this.path, this.value, true)

      // Emit some events that could be useful
      this.$emit('change', {data: this.value, path: this.path})
    },
    addDataAtt() {
      let obj = {
        att: '',
        value: ''
      }
      this.value.push(obj)
      this.handleChange()
    },
    formatLabel(el) {
      let label;
      if (this.label.includes('-')) {
        label = this.label+(el.name || '')
      } else {
        label = this.label
      }
      return label
    }
  },
  computed: {
    sibblingLink() {
      return this.component.sibblingLink || false
    },
  },
  mounted() {
    // Get any current results
    this.value = getDeep(this.component, this.path) || this.value
    // If we do have more than one, make sure none are empty
    if (this.value.length) {
      // Filter out any completely empty ones
      this.value = this.value.filter(value => value.name || value.value )  
      // Save / Cleanup the JSON (removing any empties)
      setDeep(this.component, this.path, this.value, true)  
    }
  },
  props: {
    label: String,
    path: String,
  },
  inject: ['component']
}
</script>

<style lang="scss">
  .field-repeater .field-repeater__field + .field-repeater__field {
    margin-top: 1rem;
  }
</style>