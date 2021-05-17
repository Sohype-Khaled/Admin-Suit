<template>
  <v-input>
    <input type="hidden" :name="$attrs.name" :value.sync="value">
    <Multiselect
        :searchable="searchable"
        :options="options"
        :placeholder="$attrs.placeholder"
        v-model="value"/>
  </v-input>
</template>

<script>
export default {
  name: "SelectInput",
  props: ['modelValue'],
  emits: ['update:modelValue'],
  computed: {
    value: {
      get() {
        return this.modelValue
      },
      set(value) {
        this.$emit('update:modelValue', value)
      }
    },
    options() {
      return this.$attrs.options.map(option => ({
        value: option[this.$attrs['itemValue']],
        label: option[this.$attrs['itemText']],
      }))
    },
    searchable() {
      return this.$attrs.searchable
    },
  },
}
</script>

<style scoped>

</style>