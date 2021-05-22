<template>
  <div class="btn-group" v-if="displays.length > 1">
    <button
        :key="i"
        v-for="(display_view, i) in displays"
        type="button"
        :class="{'active': display_view.component === display.component}"
        class="btn btn-outline-info btn-sm"
        @click="$emit('update:display', display_view)">
      <i :class="display_view.attrs.icon"></i>
    </button>
  </div>
</template>

<script>
export default {
  name: "DisplaySwitch",
  props: ['displays', 'display'],
  emits: ['update:display']
}
</script>

<style scoped>

</style>