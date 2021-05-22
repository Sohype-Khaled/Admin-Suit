<template>
  <div class="tree list-group">
    <v-nested-set-item
        :key="i"
        v-for="(item, i) in $attrs.items"
        :item="item"/>
  </div>
</template>

<script>
import FieldActivator from "../FieldActivator";
import NestedSetItem from "./NestedSetItem";

export default {
  name: "NestedSetDisplay",
  inheritAttrs: false,
  components: {
    vFieldActivator: FieldActivator,
    vNestedSetItem: NestedSetItem
  },
  props: {
    fields: Array,
    visibleFields: Array,
    selected: Array,
    withActions: {type: Boolean, default: false},
    actions: Object,
  },
}
</script>

<style scoped>

</style>