<template>
  <settings-modal>
    <title-editor label="Title" path="content.title" />
    <image-uploader label="Blurb Image:" path="content.image"></image-uploader>
    <component :is="editorType" path="content.body"></component>
    <toggle-switch label="Enable Button 1" path="options.buttonOneEnabled" />
    <transition name="fade">
      <Button name="button" path="content.button" :key="component.id+'blurb-button'" v-show="buttonEnabled || component.options.buttonOneEnabled" />
    </transition>
    <toggle-switch label="Enable Button 2" path="options.buttonTwoEnabled" />
    <transition name="fade">
      <Button name="button" path="content.buttontwo" :key="component.id+'blurb-buttontwo'" v-show="component.options.buttonTwoEnabled" />
    </transition>
  </settings-modal>
</template>
<script>
import { setDeep, getDeep } from "../functions/objectHelpers";
import { mapGetters } from "vuex";

export default {
  name: "blurb-module",
  data: function() {
    return {
      icon: "CoffeeIcon",
      keepInBounds: true,
      type: "blurb-module",
    };
  },
  computed: {
    ...mapGetters(["isWP"]),
    buttonEnabled() {
      return getDeep(this.component, "content.button.buttonEnabled") || false;
    },
    editorType() {
      return this.isWP ? "rich-tiny" : "rich-text";
    }
  },
  props: {
    hidecontrols: Boolean,
    component: Object
  },
  methods: {
    setDeep
  }
};
</script>
