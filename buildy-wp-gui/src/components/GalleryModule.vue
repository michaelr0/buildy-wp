<template>
  <settings-modal @open="">
    <attribute-editor label="Title" path="content.title"></attribute-editor>
    <div class="gallery-wrapper">
      <ul class="gallery-module">
        <draggable :list="images" v-bind="dragOptions">
          <li
            @click.prevent="openMediaLibrary"
            v-for="image in images"
            :key="image.id"
            class="gallery-module__item"
          >
            <trash-2-icon
              @click.stop="removeImage(image.id)"
              class="text-white absolute delete-image-icon cursor-pointer"
              size="1.5x"
            ></trash-2-icon>
            <img :src="image.url" />
          </li>
          <li class="gallery-module__item">
            <div class="image-uploader h-full module module-settings">
              <div
                @click.prevent="openMediaLibrary"
                class="flex w-full h-full border-2 border-dashed border-gray-600 relative cursor-pointer items-center justify-center image-selector"
              >
                <span
                  ><label
                    class="pb-2"
                    v-text="images.length ? 'Add More' : 'Add Images'"
                  />
                  +</span
                >
              </div>
            </div>
          </li>
        </draggable>
      </ul>
    </div>

    <div class="flex -mx-2">
      <attribute-editor
        class="px-2 flex-1"
        label="Gallery Columns"
        :path="`${path}.columnCount`"
      />
      <attribute-editor
        class="px-2 flex-1"
        label="Column Gap"
        :path="`${path}.columnGap`"
      />
    </div>

    <div class="flex">
      <div class="flex">
        <toggle-switch
          label="Convert to slider?"
          path="content.gallery.isSlider"
        />
      </div>
    </div>

    <div slot="options" class="image-custom-options">
      <div class="flex">
        <toggle-switch
          label="Show Title Attributes?"
          path="options.titleAtts"
        />
      </div>
      <fieldset
        v-show="component.options.titleAtts"
        class="title-atts border p-4 mt-4"
      >
        <h3 class="text-xl font-bold text-center">Title Attributes</h3>
        <attribute-editor
          label="Title ID"
          path="content.title.id"
        ></attribute-editor>
        <attribute-editor
          label="Title Class"
          path="content.title.class"
        ></attribute-editor>
      </fieldset>
    </div>
  </settings-modal>
</template>
<script>
import { mapGetters } from "vuex";
import draggable from "vuedraggable";
import mediaLibrary from "../mixins/mediaLibrary";
import { Trash2Icon } from "vue-feather-icons";
import { setDeep, getDeep } from "../functions/objectHelpers";

export default {
  name: "gallery-module",
  props: {
    component: Object,
  },
  computed: {
    ...mapGetters(["dragDisabled"]),
    dragOptions() {
      return {
        group: "gallery-images",
        ghostClass: "ghost",
      };
    },
  },
  mixins: [mediaLibrary],
  data: function() {
    return {
      icon: "ImageIcon",
      images: [],
    };
  },
  components: {
    draggable,
    Trash2Icon,
  },
  methods: {
    addImages(images) {
      if (images) {
        this.images = images;
        setDeep(this.component, "content.gallery.images", this.images);
      }
    },
    removeImage(id) {
      this.images = this.images.filter((el) => el.id !== id);
      setDeep(this.component, "content.gallery.images", this.images);
    },
  },
  mounted() {
    this.images = getDeep(this.component, "content.gallery.images") || [];
  },
};
</script>
<style scoped lang="scss">
.gallery-module {
  padding: 1rem;
  margin-bottom: 1rem;
  background: #e2e8f0;
  > div {
    display: grid;
    gap: 1rem;
    grid-template-columns: repeat(3, 1fr);
    grid-auto-rows: 100px;
  }
  &__item {
    position: relative;
    cursor: pointer;
    img {
      object-fit: cover;
      width: 100%;
      height: 100%;
    }
  }
  .delete-image-icon {
    opacity: 1;
  }
}
</style>
