<template>
  <slot name="activator"
        :on="{ click:() => $emit('update:modelValue', true) }"
        :active="modelValue"/>
  <teleport v-if="modelValue" to="#modal-area">
    <div class="modal fade show d-block" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <slot :close="()=>$emit('update:modelValue', false)"/>
        </div>
      </div>
    </div>
    <div class="modal-backdrop fade show"></div>
  </teleport>
</template>

<script>
import {toRef, watch} from 'vue'

export default {
  name: "Modal",
  props: ['modelValue'],
  emits: ['update:modelValue'],
  setup(props, {emit}) {
    const value = toRef(props, 'modelValue')

    watch(value, (v) => {
      let body = document.getElementsByTagName('body')[0]
      if (v) {
        body.classList.add('modal-open')
      } else {
        body.classList.remove('modal-open')
      }
    })
  }
}
</script>

<style scoped>

</style>