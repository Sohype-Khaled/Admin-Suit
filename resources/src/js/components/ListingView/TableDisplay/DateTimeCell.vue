<template>
  <td v-if="$attrs['withLink']">
    <a :href="replace()" v-text="datetimeValue"/>
  </td>
  <td v-else v-text="datetimeValue"/>
</template>

<script>
import {fieldMixin} from "./mixins";
import moment from 'moment'
import {computed} from "vue";


export default {
  name: "DateTimeCell",
  props: ['field', 'item'],
  mixins: [fieldMixin],
  inheritAttrs: false,
  setup({item}, {attrs}) {
    const datetimeValue = computed(() => item[attrs.name] === null ? '______'
        : moment(item[attrs.name]).format(attrs.format))
    return {
      datetimeValue
    }
  }
}
</script>

<style scoped>

</style>