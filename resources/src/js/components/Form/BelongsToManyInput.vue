<template>
  <pre>{{ form }}</pre>
  <v-input v-bind="$attrs">
    <template v-slot:actions>
      <button
          class="btn btn-link btn-sm text"
          type="button"
          @click="addRecord">
        Add New {{ $attrs.Label }}
      </button>
    </template>
    <table class="table table-condensed table-sm">
      <thead>
      <tr>
        <th :key="i" v-for="(label, i) in labels" v-text="label"/>
      </tr>
      </thead>
      <tbody>
      <tr :key="i"
          v-for="(record , i) in records">
        <td :key="i"
            v-for="(field, o) in record">
          <component
              :form="value"
              v-model="value[i][field.attrs.name]"
              v-bind="field.attrs"
              :is="'v' + field.component"/>
        </td>
      </tr>
      </tbody>
    </table>
  </v-input>
</template>

<script>
import {computed, ref} from 'vue'

export default {
  name: "BelongsToManyInput",
  inheritAttrs: false,
  props: ['modelValue', 'form'],
  emits: ['update:modelValue'],
  setup({modelValue, form}, {attrs, emit}) {
    const labels = computed(() => attrs.fields.map(field => field.attrs.label)),
        records = ref([]),
        value = computed({
          get: () => modelValue,
          set: val => emit('update:modelValue', val)
        }),
        addRecord = () => {
          let valueLen = records.value.length,
              newRec = [...attrs.fields].map(field => ({
                ...field,
                attrs: {...field.attrs, key: field.attrs.name + '[' + valueLen + ']'}
              }))

          value.value[valueLen] = {}

          for (let f of newRec)
            value.value[valueLen][f.attrs.name] = value.value[valueLen][f.attrs.value] ? value.value[valueLen][f.attrs.value] : null

          records.value = [...records.value, newRec]
        }

    return {form, records, labels, value, addRecord}
  }

}
</script>

<style scoped>

</style>