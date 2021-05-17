<template>
  <v-input v-bind="$attrs">
    <template v-slot:actions>
      <button
          @click="active=true"
          class="btn btn-link btn-sm text"
          type="button">
        Add New {{ $attrs.Label }}
      </button>
    </template>
    <belongs-to-many-form
        :fields="fields"
        :title="$attrs.label"
        v-model="localForm"
        v-model:active="active"
        @submit="confirm"
        @close="close"/>
    <belongs-to-many-table
        :input="$attrs.name"
        :fields="fields"
        :labels="labels"
        :items="value"/>
  </v-input>
</template>

<script>
import {computed, onMounted, provide, ref, watch} from 'vue'

import BelongsToManyForm from "./BelongsToManyForm";
import BelongsToManyTable from "./BelongsToManyTable";

export default {
  inheritAttrs: false,
  name: "BelongsToManyInput",
  components: {BelongsToManyTable, BelongsToManyForm},
  props: {
    modelValue: {
      type: Array,
      default: () => ([])
    }
  },
  emits: ['update:modelValue'],
  setup(props, {attrs, emit}) {
    const fields = computed(() => attrs.fields),
        labels = computed(() => fields.value.map(field => field.attrs.label)),
        localForm = ref({}),
        active = ref(false),
        // value = ref([]),
        value = computed({
          get: () => props.modelValue,
          set: value => emit('update:modelValue', value)
        }),
        checkValid = () => {
          let valid = true
          for (let item in localForm.value)
            if (localForm.value.hasOwnProperty(item))
              valid = valid && localForm.value[item] !== null

          return valid
        },
        reset = () => {
          for (let field of fields.value)
            localForm.value[field.attrs.name] = field.attrs.value
        },
        close = () => {
          active.value = false
          reset()
        },
        confirm = async () => {
          if (!checkValid()) return
          value.value.push({...localForm.value})
          active.value = false
          reset()
          // emit('update:modelValue', [...value.value])
        }

    onMounted(() => reset())

    provide('fields', attrs.fields)

    provide('form', localForm)

    return {active, value, fields, localForm, labels, close, confirm, reset}
  }
}
</script>

<style scoped>

</style>