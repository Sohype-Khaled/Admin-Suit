<template>
  <table class="table table-condensed table-striped table-sm">
    <thead>
    <tr>
      <th :key="i" v-for="(label, i) in labels" v-text="label"/>
      <th></th>
    </tr>
    </thead>
    <tbody>
    <tr
        v-if="rows.length > 0"
        :key="i"
        v-for="(row , i) in rows">
      <td :key="o" v-for="(cell, o) in row">
        {{ cell.text }}
        <input type="hidden" :name="cell.name" :value="cell.value">
      </td>
      <td>
        <button
            type="button"
            class="btn btn-sm btn-danger">
          <i class="fa fa-times"></i>
        </button>
      </td>
    </tr>
    <tr v-else>
      <td :colspan="fields.length+1">Empty</td>
    </tr>
    </tbody>
  </table>
</template>

<script>
import {computed, toRefs} from 'vue'

export default {
  name: "BelongsToManyTable",
  props: ['labels', 'input', 'items', 'fields'],
  setup(props) {
    const {items, labels} = toRefs(props),
        getDataFromTargetFieldOptions = (item, name, fieldName) => {
          let field = props.fields.find(field => field.attrs.name === name),
              selectedTarget = field.attrs.options.find(option => option.id === item[name])
          return selectedTarget.options.find(option => option.id === item[fieldName])
        },
        rows = computed(() => items.value.map((item, idx) => props.fields.map(field => {
              let f = field.component === "BelongsToField"
                  ? (field['attrs']['loadOptionsFrom']
                      ? getDataFromTargetFieldOptions(item, field['attrs']['loadOptionsFrom'], field['attrs']['name'])
                      : field.attrs.options.find(option => option.id === item[field.attrs.name]))
                  : {}

              return {
                text: f[field['attrs']['itemText']],
                value: f[field['attrs']['itemValue']],
                name: `${props.input}[${idx}][${field.attrs.name}]`
              }
            }))
        )

    console.log('items', items.value)

    return {items, labels, rows}
  }
}
</script>

<style scoped>

</style>