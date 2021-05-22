<template>
  <div class="fixed-menu dropdown d-inline ml-auto">
    <a href="javascript:void(0)" class="dropdown-toggle">
      <i class="fa fa-ellipsis-v "></i>
    </a>
    <div class="dropdown-menu fixed-menu__menu">
      <div
          class="dropdown-item"
          :key="i"
          v-for="(column, i) in columns">
        <div class="form-check form-check-inline mb-1">
          <input
              class="form-check-input"
              type="checkbox"
              :id="column.attrs['name']"
              :value="column.attrs['name']"
              v-model="visible">
          <label
              class="form-check-label"
              :for="column.attrs['name']"
              v-text="column.attrs['label']"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {computed} from "vue"

export default {
  name: "FieldActivator",
  inheritAttrs: false,
  props: {
    columns: Array,
    modelValue: Array
  },
  emits: ['update:modelValue'],
  setup(props, {emit}) {
    const visible = computed({
      get: () => props.modelValue,
      set: v => emit('update:modelValue', v)
    })
    return {visible}
  }
  /* computed: {
     localValue: {
       get() {
         return this.modelValue
       },
       set(value) {
         this.$emit('update:modelValue', value)
       }
     }
   }*/
}
</script>

<style scoped>

</style>