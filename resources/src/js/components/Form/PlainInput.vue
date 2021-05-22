<template>
  <v-input>
    <input
        :name="$attrs.name"
        :type="$attrs.type"
        :placeholder="$attrs.placeholder"
        :class="{'is-invalid': !!$attrs['error-messages']}"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)">
  </v-input>
</template>

<script>
export default {
  name: "PlainInput",
  props: ['modelValue'],
  emits: ['update:modelValue']
}
</script>

<style scoped>

</style>