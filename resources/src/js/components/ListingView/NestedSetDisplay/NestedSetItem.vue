<template>
  <div :style="{'padding-left': indent +'px'}"
       :class="{'tree-item--hidden' : parentRef}"
       class="tree-item list-group-item" :data-parent="parentRef">
    <!--    <i class="fa fa-arrows move"></i>-->
    <input type="checkbox">
    <span v-text="item.name"/>
    <i v-if="item.children && item.children.length > 0"
       :class="[open ? 'fa-chevron-up' : 'fa-chevron-down']"
       class="fa"
       @click="open = !open"
       :data-ref="item.id"/>
  </div>
  <nested-set-item
      v-model:open="open"
      :ref="'child-'+child.id"
      :level="level+1"
      :parent-ref="item.id"
      v-if="item.children && item.children.length > 0"
      :key="key + '-' +i"
      :item="child"
      v-for="(child, i) in  item.children"/>
</template>

<script>
import {computed, ref} from 'vue'

export default {
  name: "NestedSetItem",
  props: {
    item: Object,
    key: Number,
    level: {type: Number, default: 0},
    parentRef: Number,
  },
  setup(props) {
    const open = ref(false),
        indent = computed(() => props.level * 30 + 20)
    return {open, indent}
  }
}
</script>

<style scoped>

</style>