<template>
  <td class="text-center">
    <i :class="[item[$attrs.name]? 'glyphicon-ok': 'glyphicon-remove']" class="glyphicon"/>
  </td>
</template>

<script>
import {fieldMixin} from "./mixins";

export default {
  name: "BooleanCell",
  inheritAttrs: false,

  props: ['item'],
  mixins: [fieldMixin]
}
</script>

<style scoped>

</style>