<template>
  <div class="table-responsive mt-2">
    <table class="table table-striped jambo_table bulk_action">
      <thead>
      <tr class="headings">
        <th v-if="withActions" class="d-flex justify-content-between align-items-center">
          <input
              @change="updateAllSelected"
              v-model="isAllSelected"
              type="checkbox"
              class="mr-2">
          <v-field-activator :columns="columns" v-model="visibleFields"/>
          <div class="ml-3"><i class="fa fa-sort-alpha-asc"></i></div>
        </th>
        <th :colspan="fields.length" v-if="selected.length > 0">
          <span style="font-weight: 500">
            Bulk Actions ( {{ selected.length }} Records Selected )
          </span>
        </th>
        <template v-else>
          <th :class="{'sortable': column.sortable, }"
              class="column-title"
              :key="i"
              v-show="column.visible"
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
import {computed, onMounted, ref, toRef, watch} from 'vue'


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
    withActions: {type: Boolean, default: false},
    actions: Object,
  },
  setup(props, {emit, attrs}) {
    const visibleFields = ref([]),
        isAllSelected = ref(false),
        selected = toRef(props, 'selected'),
        fields = toRef(props, 'fields'),
        columns = computed(() => fields.value.map(({attrs, component}) => ({
          component, attrs, visible: visibleFields.value.includes(attrs.name)
        }))),
        visibleColumns = computed(() => columns.value.filter(column => column.visible)),
        updateAllSelected = () => (isAllSelected.value ? emit('update:selected', attrs.items.map(item => item.id)) : emit('update:selected', []))

    watch(selected, (v) => {
      let items = attrs.items.map(item => item.id).slice().sort(),
          val = v.slice().sort()
      isAllSelected.value = val.length === items.length && val.every((item, idx) => item === items[idx]);
      emit('update:selected', v)
    })

    onMounted(() => {
      visibleFields.value = [...props.visibleFields]
    })
    return {visibleColumns, columns, visibleFields, isAllSelected, updateAllSelected}
  }
}
</script>

<style scoped>

</style>