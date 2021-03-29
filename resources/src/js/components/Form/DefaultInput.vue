<template>
  <v-input>
    <input
        :name="$attrs.name"
        :type="$attrs.type"
        class="form-control"
        :placeholder="$attrs.placeholder"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)">
  </v-input>
</template>

<script>
export default {
  name: "DefaultInput",
  props: ['modelValue', 'form'],
  emits: ['update:modelValue']
}
</script>

<style scoped>

</style>