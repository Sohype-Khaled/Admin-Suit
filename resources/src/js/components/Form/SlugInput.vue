<template>
  <v-input>
    <template v-slot:actions>
      <button
          class="btn btn-link btn-sm text"
          type="button"
          @click="change"> Change
      </button>
      <button
          class="btn btn-link btn-sm text"
          :disabled="!targetValue"
          type="button"
          @click="slugifyTarget">Slugify Target
      </button>
      <button
          class="btn btn-link btn-sm text"
          type="button"
          :disabled="!modelValue"
          @click="slugifyContent">Slugify content
      </button>
    </template>
    <input
        :name="$attrs.name"
        :disabled="!editable"
        class="form-control"
        :placeholder="$attrs.placeholder"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        type="text">
  </v-input>
</template>

<script>
import {ref, computed} from 'vue'

export default {
  name: "SlugInput",
  props: ['modelValue', 'form'],
  emits: ['update:modelValue'],
  setup({modelValue, form}, {emit, attrs}) {
    const editable = ref(false),
        targetValue = computed(() => attrs.target ? form[attrs.target] : ''),
        slugify = (text) => text.toString().toLowerCase()
            .replace(/\s+/g, '-')
            .replace(/[^\w\-]+/g, '')
            .replace(/\-\-+/g, '-')
            .replace(/^-+/, '')
            .replace(/-+$/, ''),

        slugifyTarget = (target) => emit('update:modelValue', slugify(targetValue)),
        slugifyContent = (event) => {
          emit('update:modelValue', slugify(modelValue))
        }

    return {
      editable,
      targetValue,
      slugifyTarget,
      slugifyContent
    }
  }
  /*data () {
    return {
      editable: false
    }
  },
  computed: {
    targetValue() {
      return this.$attrs.target ? this.form[this.$attrs.target] : ''
    }
  },
  methods: {
    change() {
      console.log( this.editable)
      this.editable = !this.editable
    },
    slugify(text) {
      return text.toString().toLowerCase()
          .replace(/\s+/g, '-')
          .replace(/[^\w\-]+/g, '')
          .replace(/\-\-+/g, '-')
          .replace(/^-+/, '')
          .replace(/-+$/, '');
    },
    slugifyTarget() {
      this.$emit('update:modelValue', this.slugify(this.targetValue))
    },
    slugifyContent() {
      this.$emit('update:modelValue', this.slugify(this.modelValue))
    }
  },*/
}
</script>

<style scoped>

</style>