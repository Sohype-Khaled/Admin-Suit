<template>
  <td v-if="field.attrs['withLink']">
    <a :href="replace()" v-text="item[field.attrs.name]"/>
  </td>
  <td v-else v-text="item[field.attrs.name]"/>
</template>

<script>
import {fieldMixin} from "./mixins";

export default {
  name: "TextCell",
  mixins: [fieldMixin],
  props: ['field', 'item'],
}
</script>

<style scoped>

</style>