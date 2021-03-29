<template>
  <td v-if="field['withLink']">
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
  setup({item, field}) {
    const datetimeValue = computed(() => item[field.attrs.name] === null ? '______'
        : moment(item[field.attrs.name]).format(field.attrs.format))
    return {
      datetimeValue
    }
  }
}
</script>

<style scoped>

</style>