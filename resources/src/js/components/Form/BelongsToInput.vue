<template>
  <v-input v-bind="$attrs">
    <input type="hidden" :name="$attrs.name" :value="modelValue">
    <Multiselect
        :class="{'is-invalid': !!$attrs['error-messages']}"
        :searchable="searchable"
        :options="options"
        :placeholder="$attrs.placeholder"
        v-model="value"/>
  </v-input>
</template>

<script>
import {computed, inject, onMounted, ref, watch} from 'vue'

export default {
  name: "BelongsToInput",
  inheritAttrs: false,
  props: ['modelValue'],
  emits: ['update:modelValue'],
  setup(props, {attrs, emit}) {
    const form = inject('form'),
        fields = inject('fields'),
        value = computed({
          get: () => props.modelValue,
          set: value => emit('update:modelValue', value)
        }),
        mapOptions = (items) => items.map(item => ({
          value: item[attrs['itemValue']],
          label: item[attrs['itemText']]
        })),
        getTargetFieldOptions = (id, name) => {
          let field = fields.find(field => field.attrs.name === name),
              selectedOption = id ? field.attrs.options.find(option => option.id === id) : {}
          return selectedOption.options ? mapOptions(selectedOption.options) : []
        },
        getOptions = (v) => (options.value = attrs['loadOptionsFrom']
            ? getTargetFieldOptions(v[attrs['loadOptionsFrom']], attrs['loadOptionsFrom'])
            : mapOptions(attrs.options)),
        options = ref({}),
        searchable = attrs.searchable

    watch(form, (v) => getOptions(v), {deep: true, immediate: true})

    return {options, searchable, value}
  }
}
</script>

<style scoped>

</style>