<template>
  <td v-if="field.attrs['withLink']">
    <a :href="replace()" v-text="item[field.attrs['name']][field.attrs['related_column']]"/></td>
  <td v-else v-text="item[field.attrs['name']][field.attrs['related_column']]"/>
</template>

<script>
import {fieldMixin} from "./mixins";

export default {
  name: "BelongsToCell",
  props: ['field', 'item'],
  mixins: [fieldMixin]
}
</script>

<style scoped>

</style>