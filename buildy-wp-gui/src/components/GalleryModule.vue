<template>
  <settings-modal>
    <attribute-editor label="Title" path="content.title"></attribute-editor>
    <div class="gallery-wrapper">
      <ul class="gallery-module">
        <draggable :list="images" v-bind="dragOptions">
          <li
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
            <image-uploader-multi
              label="Add more"
              path="content.image"
              @imageSelection="addImages"
            ></image-uploader-multi>
          </li>
        </draggable>
      </ul>
    </div>

    <div class="flex -mx-2">
      <attribute-editor
        class="px-2 flex-1"
        v-if="path === 'content.gallery.columnCount'"
        label="Gallery Columns"
        :path="`${path}.columnCount`"
      />
      <attribute-editor
        class="px-2 flex-1"
        v-if="path === 'content.gallery.columnGap'"
        label="Column Gap"
        :path="`${path}.columnGap`"
      />
    </div>

    <div v-if="path === 'content.image'" class="flex -mx-2">
      <attribute-editor
        class="px-2 flex-1"
        label="Height"
        :path="`${path}.height`"
      />
      <attribute-editor
        class="px-2 flex-1"
        label="Max Height"
        :path="`${path}.maxHeight`"
      />
    </div>

    <div class="flex -mx-2">
      <select-box
        v-if="path === 'content.image' || imageType === 'img'"
        class="px-2 flex-1"
        label="Object Fit"
        :path="`${path}.objectFit`"
        options="auto, contain, cover, 100%"
      />
      <select-box
        v-if="path === 'content.image' || imageType === 'img'"
        class="px-2 flex-1"
        label="Object Position"
        :path="`${path}.objectPosition`"
        options="top, bottom, left, right"
      />
      <select-box
        v-if="path === 'content.image'"
        class="px-2 flex-1"
        label="Image / Title Position"
        :path="`${path}.imageTitlePosition`"
        options="Image Above, Image Below"
      />

      <select-box
        v-if="path === 'inline.backgroundImage' || imageType === 'bg'"
        class="px-2 flex-1"
        label="Background Size"
        :path="`${path}.backgroundSize`"
        options="auto, contain, cover, 100%"
      />
      <select-box
        v-if="path === 'inline.backgroundImage' || imageType === 'bg'"
        class="px-2 flex-1"
        label="Background Position"
        :path="`${path}.backgroundPosition`"
        options="center, center top, center bottom, center left, center right, top right, top left, bottom left, bottom right"
      />
      <select-box
        v-if="path === 'content.image' || imageType === 'img'"
        class="px-2 flex-1"
        label="Image Size"
        :path="`${path}.imageSize`"
        defaultVal="full"
        :options="imageSizes"
      />
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
  data: function () {
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
        this.images.push(...images);
        setDeep(this.component, "content.gallery.images", this.images);
      }
    },
    removeImage(id) {
      this.images = this.images.filter((el) => el.id !== id);
      setDeep(this.component, "content.gallery.images", this.images);
    },
  },
  mounted() {
    console.log(getDeep(this.component, "content.gallery.images"));
    this.images = getDeep(this.component, "content.gallery.images") || [];
  },
};
</script>
<style scoped lang="scss">
.gallery-module {
  padding: 1rem;
  margin-bottom: 3rem;
  background: #e2e8f0;
  > div {
    display: grid;
    gap: 1rem;
    grid-template-columns: repeat(3, 1fr);
    grid-auto-rows: 100px;
  }
  &__item {
    position: relative;
    img {
      object-fit: cover;
      width: 100%;
      height: 100%;
    }
  }
}
</style>
