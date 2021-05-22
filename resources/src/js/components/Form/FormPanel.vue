<template>
  <component
      v-model="form[input.attrs.name]"
      v-bind="input.attrs"
      :is="'v' + input.component"
      :key="i"
      v-for="(input, i)  in fields"/>
<!--  <pre>{{ form }}</pre>-->
</template>

<script>
import {computed, onMounted, provide, ref} from 'vue'

export default {
  name: "FormPanel",
  props: ['data', 'errors'],
  setup({data, errors}) {
    const form = ref({}),
        fields = computed(() => data.fields.map(field => ({...field, attrs: {...field.attrs, row: true}})))
    console.log('data', fields.value)
    console.log('errors', errors)

    onMounted(() => {
      for (let field of data.fields)
        form.value[field.attrs.name] = field.attrs.value ? field.attrs.value : null

      for (let field of fields.value)
        if (Object.keys(errors).includes(field.attrs.name))
          field.attrs['error-messages'] = [...errors[field.attrs.name]]
      console.log('form', form.value)
    })

    provide('fields', fields)
    provide('model', data.model)
    provide('form', form)

    return {fields, form}
  }
}
</script>

<style scoped>

</style>