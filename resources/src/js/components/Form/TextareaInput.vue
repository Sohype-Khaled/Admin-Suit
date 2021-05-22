<template>
  <v-input>
    <textarea
        :name="$attrs.name"
        v-bind="$attrs"
        :class="['form-control', {'is-invalid': !!$attrs['error-messages']}]"
        :placeholder="$attrs.placeholder"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)">
      </textarea>
  </v-input>
</template>

<script>
export default {
  name: "TextareaInput",
  props: ['modelValue'],
  emits: ['update:modelValue']
}
</script>

<style scoped>

</style>