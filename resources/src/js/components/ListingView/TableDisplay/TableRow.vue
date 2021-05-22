<template>
  <tr :class="[isEven? 'even': 'odd', ' pointer ', {' selected' : isSelected}]">
    <td class="a-center" v-if="withActions">
      <input
          type="checkbox"
          :value="item.id"
          v-model="localValue"
          name="table_records">
    </td>
    <component
        v-bind="{...column.attrs}"
        :item="item"
        :is="'v'+column['component']"
        :key="i"
        v-for="(column, i) in columns"/>
    <td class="last" v-if="withActions">
      <v-item-action :actions="actions[item['id']]">
        <template v-slot:activator>
          <a href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            Actions
            <i class="fa fa-chevron-down"></i>
          </a>
        </template>
      </v-item-action>
    </td>
  </tr>
</template>

<script>
import TextCell from "./TextCell";
import DateTimeCell from "./DateTimeCell";
import BelongsToCell from "./BelongsToCell";
import NumberCell from "./NumberCell";
import BooleanCell from "./BooleanCell";
import SingleItemActions from "../SingleItemActions";
import {computed} from "vue";

export default {
  name: "TableRow",
  props: {
    item: Object,
    columns: Array,
    modelValue: {type: Array, default: () => ([])},
    isEven: Boolean,
    withActions: {type: Boolean, default: false},
    actions: Object,
  },
  components: {
    vTextField: TextCell,
    vSelectField: TextCell,
    vSlugField: TextCell,
    vDateTimeField: DateTimeCell,
    vBelongsToField: BelongsToCell,
    vNumberField: NumberCell,
    vBooleanField: BooleanCell,
    vItemAction: SingleItemActions
  },
  emits: ['update:modelValue'],
  setup(props, {emit}) {
    const isSelected = computed(() => props.modelValue.includes(props.item.id)),
        localValue = computed({
          get: () => props.modelValue,
          set: v => emit('update:modelValue', v)
        })

    return {isSelected,localValue}
  }
}
</script>

<style scoped>

</style>