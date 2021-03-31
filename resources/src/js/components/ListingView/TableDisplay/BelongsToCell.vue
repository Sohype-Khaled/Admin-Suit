<template>
   <td v-if="$attrs['withLink']">
    <a :href="replace()" v-text="item[$attrs['name']][$attrs['nameColumn']]"/></td>
  <td v-else v-text="item[$attrs['name']][$attrs['nameColumn']]"/>
</template>

<script>
import {fieldMixin} from "./mixins";

export default {
  name: "BelongsToCell",
  inheritAttrs: false,
  props: ['item'],
  mixins: [fieldMixin]
}
</script>

<style scoped>

</style>