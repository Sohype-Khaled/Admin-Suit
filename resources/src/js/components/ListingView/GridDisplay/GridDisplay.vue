<template>
  image
  fields
  actions
  test
</template>

<script>
import {computed, onMounted, ref, toRef, watch} from "vue";

export default {
  name: "GridDisplay",
  inheritAttrs: false,
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