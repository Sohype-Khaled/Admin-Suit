<template>
  <slot name="activator"></slot>
  <div class="dropdown-menu">
    <template
        :key="i"
        v-for="(action, i) in actions">
      <a class="dropdown-item"
         :href="action['route']"
         v-text="action['text']" v-if="action['type'] === 'link'"/>
      <a href="javascript:void(0)"
         class="dropdown-item admin-suit-action"
         :class="{'text-danger': action['danger']}"
         :data-title="action['message_title']"
         :data-message="action['message_body']"
         :data-model="action['action_model']"
         :data-action="action['action_class']"
         :data-items="action['action_items']"
         :data-value="action['action_value']"
         data-toggle='modal'
         data-target='#admin-suit-action-modal'
         v-text="action['text']"
         v-else/>
    </template>
  </div>
</template>

<script>
export default {
  name: "SingleItemActions",
  props: {
    actions: Array
  },
}
</script>

<style scoped>

</style>