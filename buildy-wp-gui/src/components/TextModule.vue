<template>
  <settings-modal>
    <title-editor label="Title" path="content.title" />
    <component :is="editorType" path="content.body"></component>
  </settings-modal>
</template>
<script>
import { mapGetters } from "vuex";

export default {
  name: "text-module",
  data: function() {
    return {
      icon: "AlignJustifyIcon"
    };
  },
  computed: {
    ...mapGetters(["isWP"]),
    editorType() {
      return this.isWP ? "rich-tiny" : "rich-text";
    }
  }
};
</script>
