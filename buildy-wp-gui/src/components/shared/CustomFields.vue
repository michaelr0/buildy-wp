<template>
  <fieldset
    :key="`${component.id}-${moduleStyle}`"
    v-if="moduleStyle && moduleStyle !== 'None'"
    class="field-group"
  >
    <legend class="uppercase text-sm px-4">
      Custom fields:
    </legend>
    <span class="text-xs italic -mt-3 mb-3 block lowercase"
      >add
      {{ `${moduleName}-${moduleStyle}.blade.php` }}
      under buildy-views->modules in your theme folder
    </span>
    <field-repeater
      label="Custom Fields"
      :path="path || `content.customFields.${moduleStyle}`"
      :endpoint="`bmcb/v1/module_styles=${moduleName}`"
    ></field-repeater>
  </fieldset>
</template>

<script>
export default {
  name: "custom-fields",
  props: {
    path: String
  },
  data: function() {
    return {};
  },
  computed: {
    moduleName() {
      return this.component.type.split("-")[0];
    },
    moduleStyle() {
      return (
        this.component.options.moduleStyle &&
        this.component.options.moduleStyle.replace(/\s+/g, "-").toLowerCase()
      );
    }
  },
  inject: ["component"]
};
</script>

<style></style>
