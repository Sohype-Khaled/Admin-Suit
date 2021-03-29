<template>
  <v-input>
    <input
        :name="$attrs.name"
        :type="$attrs.type"
        :placeholder="$attrs.placeholder"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)">
  </v-input>
</template>

<script>
export default {
  name: "PlainInput",
  props: ['modelValue', 'form'],
  emits: ['update:modelValue']
}
</script>

<style scoped>

</style>