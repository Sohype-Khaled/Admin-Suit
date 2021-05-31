<template>
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="mt-2 mb-3 d-flex align-items-center">
          <div class="d-flex justify-content-between align-items-center mr-2" style="width: 30px">
            <input
                @change="updateAllSelected"
                v-model="isAllSelected"
                type="checkbox"
                class="mr-2">
            <v-field-activator :columns="columns" v-model="visibleFields"/>
          </div>
          <div class="mx-2 detail-item" style="cursor: pointer">
            <i class="fa fa-sort-alpha-asc"></i>
          </div>
          <p
            v-for="(column, i) in visibleColumns"
            :key="i"
            v-text="column['attrs']['label']"
            class="mx-2 mb-0 detail-item"
          />
        </div>
      </div>
      <template v-if=" $attrs.items.length > 0">
        <div class="col-lg-3" v-for="(item, i) in $attrs.items" :key="i">
          <v-grid-item
              :item="item"
              :actions="actions"
              :with-actions="withActions"
              :visible-fields="visibleFields"/>
      </div>
      </template>
      <div v-else>
        there is no items
      </div>
    </div>
  </div>
</template>

<script>
import FieldActivator from "../FieldActivator"
import {computed, onMounted, ref, toRef, watch} from "vue";
import SingleItemActions from "../SingleItemActions";
import GridItem from "./GridItem";

export default {
  name: "GridDisplay",
  inheritAttrs: false,
  components: {
    vFieldActivator: FieldActivator,
    vItemAction: SingleItemActions,
    vGridItem: GridItem
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
  .detail-item{
  background-color: #18A2B8;
  padding: 8px 16px;
  border-radius: 5px;
  color: #fff;
}
</style>