<template>
  <component
      :form="form"
      v-model="form[input.attrs.name]"
      v-bind="input.attrs"
      :is="'v' + input.component"
      :key="i"
      v-for="(input, i)  in fields"/>
</template>

<script>
import {computed, ref} from 'vue'

export default {
  name: "FormPanel",
  props: ['form', 'errors'],
  setup(props) {
    console.log('form', props.form)
    console.log('errors', props.errors)
    const form = ref({}),
        model = computed(() => props.form.model),
        instance = computed(() => props.form.instance),
        fields = computed(() => props.form.fields.map(field => ({
          ...field,
          attrs: {
            ...field.attrs,
            row: true
          }
        })))

    for (let field of props.form.fields)
      form.value[field.attrs.name] = field.attrs.value ? field.attrs.value : null

    for (let field of fields.value)
      if (Object.keys(props.errors).includes(field.attrs.name))
        field.attrs['error-messages'] = [...props.errors[field.attrs.name]]

    return {
      form, model, instance, fields, errors: props.errors
    }
  }
}
</script>

<style scoped>

</style>