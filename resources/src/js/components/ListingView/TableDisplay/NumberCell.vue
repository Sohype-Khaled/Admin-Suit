<template>
    <td v-if="$attrs['withLink']">
      <a :href="replace()" v-text="item[$attrs.name]"/>
    </td>
    <td v-else v-text="item[$attrs.name]"/>
</template>

<script>
import {fieldMixin} from "./mixins";

export default {
  name: "NumberCell",
  inheritAttrs: false,
  props: ['item'],
  mixins: [fieldMixin]
}
</script>

<style scoped>

</style>