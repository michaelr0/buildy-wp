<template>
  <div class="image-uploader h-full module module-settings">
    <div
      @click.prevent="openMediaLibrary(images)"
      class="flex w-full h-full border-2 border-dashed border-gray-600 relative cursor-pointer items-center justify-center image-selector"
    >
      <span><label class="pb-2" v-if="label" v-text="label" /> +</span>
    </div>
  </div>
</template>

<script>
import { setDeep, getDeep } from "../../functions/objectHelpers";
import mediaLibrary from "../../mixins/mediaLibrary";
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters(["imageSizes"]),
    images() {
      return this.component.content.gallery.images || null;
    },
  },
  mixins: [mediaLibrary],
  props: {
    bgImage: Boolean,
    path: {
      type: String || Array,
      default: "content.image",
    },
    imageType: String,
    label: String,
  },
  mounted() {
    if (this.customMediaLibrary) {
      this.customMediaLibrary.on("select", () => {
        var selectedImages = this.customMediaLibrary.state().get("selection");
        this.selection = selectedImages.map((attachment) => {
          attachment = attachment.toJSON();
          let imageData = {
            url: attachment.url,
            id: attachment.id,
          };

          return imageData;
        });
        this.$emit("imageSelection", this.selection);
      });
    }
  },
  inject: ["component"],
  provide() {
    return {
      component: this.component,
    };
  },
};
</script>

<style scoped>
.image-selector:hover {
  @apply bg-gray-200;
}

.delete-image-icon {
  opacity: 1;
}
</style>
