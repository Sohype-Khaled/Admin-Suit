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
              :disabled="localValue.length <= 2"
              class="form-check-input"
              type="checkbox"
              :id="column.attrs['name']"
              :value="column.attrs['name']"
              v-model="localValue">
          <label class="form-check-label" :for="column.attrs['name']">{{ column.attrs['label'] }}</label>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "FieldActivator",
  props: {
    columns: Array,
    modelValue: Array
  },
  emits: ['update:modelValue'],
  computed: {
    localValue: {
      get() {
        return this.modelValue
      },
      set(value) {
        this.$emit('update:modelValue', value)
      }
    }
  }
}
</script>

<style scoped>

</style>