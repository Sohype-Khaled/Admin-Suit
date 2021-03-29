<template>
  <div class="d-flex justify-content-center align-items-center">
    <p href="javascript:void(0)" class="m-0 p-0 btn-link disabled d-inline">{{ itemsText }}</p>
    <i class="d-block fa fa-chevron-left btn pt-0 pb-0 m-0 text-muted"
       @click="localPage--"
       :class="{'disabled':localPage === 1}"
       style="cursor: pointer"
    ></i>
    <p class="m-0 p-0 btn-link disabled">{{ pagesText }}</p>
    <i class="d-block fa fa-chevron-right btn pt-0 pb-0 m-0 text-muted"
       @click="localPage++"
       :class="{'disabled':localPage === paginator['last_page']}"
       style="cursor: pointer"
    ></i>
    <select
        class="form-control form-control-sm form-control-border"
        style="width: 80px; border-radius: 5px"
        v-model="localPerPage">
      <option :value="option"
              :selected="perPage === option"
              :key="i"
              v-for="(option, i) in perPageOptions"
              v-text="option"/>
    </select>
  </div>
</template>

<script>
export default {
  name: "Pagination",
  props: {
    paginator: Object,
    perPage: {
      type: Number,
      default: 10
    },
    perPageOptions: Array,
    page: {
      type: Number,
      default: 1
    },
  },
  computed: {
    localPage: {
      get() {
        return this.page
      },
      set(value) {
        this.$emit('update:page', value)
      }
    },
    localPerPage: {
      get() {
        return this.perPage
      },
      set(value) {
        this.$emit('update:per-page', value)
      }
    },
    itemsText() {
      return `${this.paginator['from'] ? this.paginator['from'] : 1} - ${this.paginator['to'] ? this.paginator['to'] : 1} / ${this.paginator['total'] ? this.paginator['total'] : 1}`
    },
    pagesText() {
      return `${this.paginator['current_page']} of ${this.paginator['last_page']}`
    }
  },
  emits: ['update:page', 'update:per-page'],
}
</script>

<style scoped>

</style>