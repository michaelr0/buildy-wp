<template>
  <div class="select-box-module module-settings mt-0 flex flex-col relative">
    <label class="pr-4 pb-1 setting-label">{{ label }}:</label>
    <select
      class="select-box rounded p-2"
      v-model="value"
      @change="handleChange"
    >
      <option value="None">None</option>
      <option
        v-for="(option, i) in optionsArr"
        :key="option + i"
        class="select-choice flex"
        :value="option"
        >{{ option }}</option
      >
    </select>
  </div>
</template>

<script>
// import { EventBus } from '../../../EventBus';
import { getDeep, setDeep } from "../../functions/objectHelpers";
export default {
  props: {
    label: String,
    range: Number,
    options: String,
    path: String,
    selected: String
  },
  data() {
    return {
      value: "None"
    };
  },
  computed: {
    optionsArr() {
      return this.range
        ? Array.from(Array(this.range).keys())
        : this.options
        ? this.options.split(",").map(el => el.trim())
        : null;
    }
  },
  methods: {
    handleChange() {
      this.$emit("change", this.value || null);
      if (this.component && this.path) {
        setDeep(this.component, this.path, this.value);
      }
    }
  },
  mounted() {
    if (this.selected) {
      this.value = this.selected.trim();
    }

    if (!this.selected && this.path) {
      this.value = getDeep(this.component, this.path) || "None";
    }

    this.$emit("change", this.value);
  },
  inject: ["component"]
};
</script>

<style lang="scss" scoped>
select {
  width: 100%;
  background: #f1f1f1;
  border-radius: 0.3rem;
  box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.2);
  cursor: pointer;
  margin: 0 auto;
  flex-grow: 1;
  padding: 0.5rem;
  position: relative;
}
</style>
