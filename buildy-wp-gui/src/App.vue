<template>
  <div v-if="pageBuilder" id="buildy-root" class="page-wrap">
    <textarea
      id="buider"
      class="mt-1 mb-4 w-full hidden"
      name="content"
      v-model="pageBuilderOutput"
    />
    <container-module
      :pageBuilder="pageBuilder"
      :globalAPI="configAPI"
      adminClass="w-full"
    ></container-module>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      pageBuilder: [],
      output: []
    };
  },
  computed: {
    pageBuilderOutput() {
      return JSON.stringify(this.pageBuilder);
    },
    configAPI() {
      if (this.config.length) {
        const configObj = JSON.parse(this.config);
        // console.log(configObj);
        return configObj.global_api;
      }
      return "";
    }
  },
  props: {
    msg: String,
    config: Array,
    content: Array
  },
  mounted() {
    if (this.config) {
      this.$store.dispatch('config', JSON.parse(this.config))
    }

    if (this.content) {
      this.pageBuilder.push(...this.content);
    }
  }
};
</script>

<style lang="scss">
$colors: "red", "blue", "pink", "orange", "cyan", "lightgray", "gray", "white",
  "black";
@each $color in $colors {
  .bg-#{$color} {
    background-color: var(--#{$color});
  }
  .text-#{$color} {
    color: var(--#{$color});
  }
  .border-#{$color} {
    border-color: var(--#{$color});
  }
}
</style>
