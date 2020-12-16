<template>
  <settings-modal>
    <title-editor label="Title" path="content.title" />
    <accordion path="content.slider.items" isSlider />
  </settings-modal>
</template>
<script>
export default {
  name: "slider-module",
  data: function () {
    return {
      icon: "SlidersIcon",
    };
  },
};
</script>
