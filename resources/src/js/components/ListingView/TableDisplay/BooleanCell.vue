<template>
  <td class="text-center">
    <i :class="[item[field.attrs.name]? 'glyphicon-ok': 'glyphicon-remove']" class="glyphicon"/>
  </td>
</template>

<script>
import {fieldMixin} from "./mixins";

export default {
  name: "BooleanCell",
  props: ['field', 'item'],
  mixins: [fieldMixin]
}
</script>

<style scoped>

</style>