<template>
  <div class="cta-button module module-settings mt-0">
      <div class="flex flex-wrap items-center">
        <div class="flex-grow">
          <div class="flex flex-col mb-2">
              <label :for="(label + '-button-text-' + index)" class="pr-4 setting-label flex-shrink-0">Button Text:</label>
              <input :id="(label + '-button-text-' + index)" class="text-gray-800 w-full border-2 p-2" @blur="change" v-model="payload.text" />
          </div>
          <div class="flex flex-col mb-2">
              <label :for="(label + '-button-url-' + index)" class="pr-4 setting-label flex-shrink-0">URL:</label>
              <input :id="(label + '-button-url-' + index)" class="text-gray-800 w-full border-2 p-2" @blur="change" v-model="payload.url" />
          </div>
        </div>
        <div v-if="payload.text" class="preview max-w-xs pl-10">
            <p
            ref="buttonText"
            class="button-text btn mx-auto rounded border-2 mb-0"
            :class="[
                (showBackground) ? `bg-${payload.backgroundColor} border-${payload.backgroundColor}` : '',
                payload.colour ? `text-${payload.colour}` : '',
                (payload.outlined && payload.borderColor) ? `border-${payload.borderColor}` : ''
            ]"
            contenteditable="true"
            >{{ payload.text }}</p>
        </div>
      </div>
      <div class="flex items-center py-3 mb-4">
          <div class="flex flex-col items-center justify-center mr-6">
              <label :for="(label + '-button-colour-' + index)" class="pb-1">Text</label>
              <select class="w-full p-2" :id="(label + '-button-colour-' + index)" @blur="change" v-model="payload.colour">
                  <option v-for="colour in colours" :key="component.id + label + '-colour-' + colour">{{ colour }}</option>
              </select>
          </div>
          <div v-if="payload.outlined" class="flex  mr-6 flex-col items-center justify-center">
              <label :for="(label + '-button-borderColor-' + index)" class="pb-1">Border</label>
              <select class="w-full p-2" :id="(label + '-button-borderColor-' + index)" @change="change" v-model="payload.borderColor">
                  <option v-for="colour in colours" :key="component.id + label + '-border-' + colour">{{ colour }}</option>
              </select>
          </div>
          <div v-if="(showBackground)" class="flex flex-col items-center justify-center">
              <label :for="(label + '-button-bg-' + index)" class="pb-1">Background</label>
              <select class="w-full p-2" :id="(label + '-button-bg-' + index)" @blur="change" v-model="payload.backgroundColor">
                  <option v-for="colour in colours" :key="component.id + label + '-bg-' + colour">{{ colour }}</option>
              </select>
          </div>
      </div>
      <div class="flex">
        <toggle-switch class="flex-col items-baseline" label="Outlined" :status="payload.outlined" :path="`${path}.outlined`" @toggle="handleToggle('outlined', $event)"></toggle-switch>
        <toggle-switch class="flex-col items-baseline" v-if="payload.outlined" label="Background" :path="`${path}.showBackground`" :status="payload.showBackground" @toggle="handleToggle('showBackground', $event)"></toggle-switch>
        <toggle-switch class="flex-col items-baseline" label="New window?" :path="`${path}.target`" :status="payload.target" @toggle="handleToggle('target', $event)"></toggle-switch>
      </div>
  </div>
</template>

<script>
import { setDeep, getDeep } from "../../functions/objectHelpers";
import { mapGetters } from "vuex";

export default {
  name: "cta-button",
  data: function() {
    return {
      payload: {
        text: "",
        url: "",
        colour: "",
        borderColor: "",
        backgroundColor: "",
        target: false,
        outlined: false,
        unStyled: false,
        showBackground: false
      }
    };
  },
  computed: {
    ...mapGetters(["colours"]),
    showBackground() {
      if (this.payload.showBackground) {
        return true;
      }
      if (!this.payload.outlined && !this.payload.unStyled) {
        return true;
      }
      return false;
    }
  },
  props: {
    label: {
      type: String,
      default: "button"
    },
    enabled: {
      type: Boolean,
      default: true
    },
    index: {
      type: Number,
      default: 0
    },
    path: {
      type: String,
      default: "content.button"
    }
  },
  methods: {
    handleToggle() {
      setDeep(this.component, this.path, this.payload);
    },
    change() {
      setDeep(this.component, this.path, this.payload);
    }
  },
  mounted() {
    this.payload = getDeep(this.component, this.path) || this.payload;
  },
  inject: ["component"]
};
</script>

<style scoped>
select.w-full {
  max-width: none;
}
</style>
