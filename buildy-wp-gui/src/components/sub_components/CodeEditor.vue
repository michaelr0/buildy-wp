<template>
  <div class="module module-settings">
    <span v-if="header" class="text-2xl block mb-4" v-text="header" />
    <prism-editor :code="value" language="html" @change="change"></prism-editor>
  </div>
</template>
<script>
import { setDeep, getDeep } from "../../functions/objectHelpers";
import PrismEditor from "vue-prism-editor";

// @ts-ignore
export default {
  name: "code-editor",
  data: function() {
    return {
      value: getDeep(this.component, this.path) || ""
    };
  },
  props: {
    path: String,
    header: String
  },
  methods: {
    change(e) {
      this.value = e;
      setDeep(this.component, this.path, this.value);
      this.$emit("change", { data: this.value, path: this.path });
    }
  },
  components: {
    PrismEditor
  },
  inject: ["component"]
};
</script>
