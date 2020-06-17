<template>
  <settings-modal>
    <title-editor label="Title" path="content.title" />
    <accordion path="content.accordion.items" />
  </settings-modal>
</template>
<script>
export default {
  name: "accordion-module",
  data: function() {
    return {
      icon: "menuIcon"
    };
  }
};
</script>
