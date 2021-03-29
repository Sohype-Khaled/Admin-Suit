<template>
    <td v-if="field.attrs['withLink']">
      <a :href="replace()" v-text="item[field.attrs.name]"/>
    </td>
    <td v-else v-text="item[field.attrs.name]"/>
</template>

<script>
import {fieldMixin} from "./mixins";

export default {
  name: "NumberCell",
  props: ['field', 'item'],
  mixins: [fieldMixin]
}
</script>

<style scoped>

</style>