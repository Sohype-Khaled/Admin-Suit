<template>
  <div class="form-group"
       :class="{'row': row}">
    <label v-if="!$attrs.hideLabel"
           :class="{'control-label col-md-3 col-sm-3': row}"
           :for="'v-input__' + $attrs.name"
           v-text="$attrs.label"/>
    <div class="col-md-9 col-sm-9" v-if="row && !$attrs.hideLabel">
      <slot name="actions"></slot>
      <slot :id="'v-input__' + $attrs.name" v-bind="{...$attrs, ...$props}"/>
      <div class="invalid-feedback" v-if="errorMessages.length > 0">
      <span
          :key="i"
          v-for="(msg, i) in errorMessages"
          v-text="msg"/>
      </div>
    </div>
    <slot v-else/>
    <div class="invalid-feedback" v-if="errorMessages.length > 0">
      <span
          :key="i"
          v-for="(msg, i) in errorMessages"
          v-text="msg"/>
    </div>
  </div>
</template>

<script>
export default {
  name: "Input",
  inheritAttrs: false,
  props: {
    row: {type: Boolean, default: false},
    errorMessages: {type: Array, default: () => ([])},
    hint: {type: String, default: ''}
  }
}
</script>

<style scoped>

</style>