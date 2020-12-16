<template>
  <settings-modal>
    <title-editor label="Title" path="content.title" />
    <accordion path="content.slider.items" isSlider />
    <div slot="options" class="slider-custom-options">
      <attribute-editor
        label="Interval"
        placeholder="Time between slide changes - Default: 5000"
        path="options.slider.duration"
      />
      <attribute-editor
        label="Duration"
        placeholder="Duration of the slide animation - Default: 200"
        path="options.slider.duration"
      />
      <attribute-editor
        label="Easing"
        placeholder="Default: ease-out"
        path="options.slider.easing"
      />
      <attribute-editor
        label="Per Page"
        placeholder="Default: 1"
        path="options.slider.perPage"
      />
      <attribute-editor
        label="Start Index"
        placeholder="Default: 0"
        path="options.slider.startIndex"
      />
      <attribute-editor
        label="Draggable"
        placeholder="Default: true"
        path="options.slider.draggable"
      />
      <attribute-editor
        label="Threshold"
        placeholder="Default: 20"
        path="options.slider.threshold"
      />
      <attribute-editor
        label="Loop"
        placeholder="Default: true"
        path="options.slider.loop"
      />
      <attribute-editor
        label="Right to left"
        placeholder="Default: false"
        path="options.slider.rtl"
      />
    </div>
  </settings-modal>
</template>
<script>
export default {
  name: "slider-module",
  data: function() {
    return {
      icon: "SlidersIcon"
    };
  }
};
</script>
