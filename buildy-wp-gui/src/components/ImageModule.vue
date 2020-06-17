<template>
  <settings-modal>
    <attribute-editor label="Title" path="content.title"></attribute-editor>
    <image-uploader label="Image:" path="content.image"></image-uploader>
  </settings-modal>
</template>
<script>
export default {
  name: "image-module",
  data: function() {
    return {
      icon: "ImageIcon"
    };
  }
};
</script>
