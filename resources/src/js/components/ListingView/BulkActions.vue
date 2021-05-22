<template>
  <div class="btn-group ml-1">
    <button type="button"
            :disabled="selected.length === 0"
            class="btn btn-outline-danger btn-sm dropdown-toggle"
            data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
      <i class="fa fa-cogs"></i>
      Actions
    </button>
    <div class="dropdown-menu">
      <a :key="i"
         v-for="(action, i) in localActions"
         href="javascript:void(0)"
         class="dropdown-item admin-suit-bulk-action"
         :class="{'text-danger': action['danger']}"
         :data-title="action['message_title']"
         :data-message="action['message_body']"
         :data-model="action['action_model']"
         :data-action="action['action_class']"
         :data-items="selectedValue"
         :data-value="action['action_value']"
         data-toggle='modal'
         data-target='#admin-suit-action-modal'
         v-text="action['text']">
      </a>
    </div>
  </div>
</template>

<script>
import {computed} from "vue";

export default {
  name: "BulkActions",
  props: {
    actions: Object,
    selected: Array
  },
  setup(props) {
    const selectedValue = computed(() => props.selected.join(',')),
        localActions = computed(() => {
          var actions = []
          for (var action of props.actions) {
            if (Array.isArray(action))
              for (var state of action)
                actions.push(state)
            else
              actions.push(action)
          }
          return actions
        })
    return {selectedValue, localActions}
  }
}
</script>

<style scoped>

</style>