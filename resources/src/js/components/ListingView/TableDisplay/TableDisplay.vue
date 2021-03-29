<template>
  <div class="table-responsive mt-2">
    <table class="table table-striped jambo_table bulk_action">
      <thead>
      <tr class="headings">
        <th v-if="withActions">
          <input type="checkbox" id="check-all" class="mr-2">
<!--          <v-field-activator :columns="availableFields" v-model="visible"/>-->
        </th>
        <th :colspan="fields.length" v-if="selected.length > 0">
          <span style="font-weight: 500">Bulk Actions ( {{ selected.length }} Records Selected )</span>
        </th>
        <template v-else>
          <th :class="{'sortable': column.sortable, }"
              class="column-title"
              :key="i"
              v-show="column.isVisible"
              v-for="(column, i) in visibleColumns"
              v-text="column['attrs']['label']"/>
          <th v-if="withActions">
            Actions
          </th>
        </template>
      </tr>
      </thead>
      <tbody>
      <template
          v-if=" $attrs.items.length > 0"
          :key="i"
          v-for="(item, i) in $attrs.items">
        <v-table-row
            :actions="actions"
            :with-actions="withActions"
            :is-even="i % 2===0"
            :item="item"
            :columns="visibleColumns"
            v-model="selected"/>
      </template>
      <tr v-else>
        <td class="text-center" :colspan="visibleColumns.length+2">
          There is No Items Yet!
        </td>
      </tr>
      </tbody>
    </table>
  </div>
  <div>
    <slot name="pagination"/>
  </div>
</template>

<script>
import FieldActivator from "../FieldActivator"
import TableRow from "./TableRow"
import {computed, ref} from 'vue'


export default {
  name: "TableDisplay",
  inheritAttrs: false,
  components: {
    vFieldActivator: FieldActivator,
    vTableRow: TableRow,
  },
  props: {
    fields: Array,
    visibleFields: Array,
    selected: Array,
    allSelected: {type: Boolean, default: false},
    withActions: {type: Boolean, default: false},
    actions: Object,
  },
  setup({fields, visibleFields, selected, allSelected, withActions, actions}) {
    const visible = ref([]),
        availableFields = computed(() => fields.map(({attrs, component}) => ({
          isVisible: visible.value.includes(attrs.name), component, attrs
        }))),
        visibleColumns = computed(() => availableFields.value.filter(column => column.isVisible))
    visible.value = [...visibleFields]
    return {visible, availableFields, visibleColumns}
  }
  /*data() {
    return {visible: []}
  },
  computed: {
    columns() {
      return this.fields.map(({attrs, component}) => {
        return {
          isVisible: this.visible.includes(attrs.name),
          component,
          attrs
        }
      })
    },
    visibleColumns() {
      return this.columns.filter(column => {
        return column.isVisible
      })
    }
  },
  created() {
    this.visible = [...this.visibleFields]
  },*/
}
</script>

<style scoped>

</style>