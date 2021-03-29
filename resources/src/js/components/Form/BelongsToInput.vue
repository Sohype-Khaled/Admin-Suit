<template>
  <v-input v-bind="$attrs">
    <input type="hidden" :name="$attrs.key" :value.sync="value">
    <Multiselect
        v-if="$attrs.loadOptionsFrom"
        :filterResults="false"
        :minChars="1"
        :resolveOnLoad="false"
        :delay="0"
        :searchable="searchable"
        :options="async q=> await getAsyncOptions(q)"
        :placeholder="$attrs.placeholder"
        v-model="value"/>
    <Multiselect
        v-else
        :searchable="searchable"
        :options="options"
        :placeholder="$attrs.placeholder"
        v-model="value"/>
  </v-input>
</template>

<script>
import {computed, ref} from 'vue'

export default {
  name: "BelongsToInput",
  inheritAttrs: false,
  props: ['modelValue', 'form'],
  emits: ['update:modelValue'],
  setup({modelValue, form}, {attrs, emit}) {
    console.log(form)
    const value = computed({
          get: () => modelValue,
          set: value => emit('update:modelValue', value)
        }),
        options = ref([]),
        mapOptions = (items) => items.map(item => ({value: item[attrs['itemValue']], label: item[attrs['itemText']]})),
        getAsyncOptions = async () => {
          console.log(attrs['loadOptionsFrom'], form[attrs['loadOptionsFrom']], form)
          let params = {model: attrs.model}
          params[attrs['loadOptionsFrom']] = form[attrs['loadOptionsFrom']]
          let {data} = await axios.get('/admin/one2many', {params})
          return mapOptions(data.data)
        },
        searchable = attrs.searchable

    if (!attrs['loadOptionsFrom'])
      options.value = mapOptions(attrs.options)

    return {options, searchable, value, getAsyncOptions}
  },
  /*computed: {
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
    async asyncOption() {
      let {data} = await this.$axios.get('/admin/one2many', {
        params: {model: this.$attrs.model}
      })
      this.options = data.data.map(item => {
        return {
          value: item[this.$attrs['itemValue']],
          label: item[this.$attrs['itemText']]
        }
      })
    },
    localOptions() {
      return this.$attrs['loadOptionsFrom'] ? this.asyncOption : this.options
    }
  },*/
}
</script>

<style scoped>

</style>