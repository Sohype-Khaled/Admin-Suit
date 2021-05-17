<template>
  <modal v-model="active">
    <template #default="{close}">
      <div class="modal-header">
        <h4 class="modal-title" v-text="title"/>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="$emit('close')">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form @submit.prevent="$emit('submit')">
        <div class="modal-body">
          <component
              :required="true"
              v-model="form[field.attrs.name]"
              v-bind="field['attrs']"
              :is="'v' + field['component']"
              :key="i"
              v-for="(field, i)  in fields"/>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="$emit('close')">
            Close
          </button>
          <button type="submit" class="btn btn-primary"> Save changes</button>
        </div>
      </form>
    </template>
  </modal>
</template>

<script>
import Modal from "../../Modal";
import {computed, toRef} from 'vue'

export default {
  inheritAttrs: false,
  name: "BelongsToManyForm",
  components: {Modal},
  props: ['modelValue', 'fields', 'active', 'title'],
  emits: ['update:active', 'update:modelValue', 'close', 'submit'],
  setup(props, {emit}) {
    const fields = toRef(props, 'fields'),
        active = toRef(props, 'active'),
        title = toRef(props, 'title'),
        form = computed({
          get: () => props.modelValue,
          set: val => emit('update:modelValue', val)
        })

    return {form, fields, active, title}
  }
}
</script>

<style scoped>

</style>