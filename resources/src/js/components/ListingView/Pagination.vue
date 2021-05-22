<template>
  <div class="d-flex justify-content-center align-items-center">
    <p href="javascript:void(0)"
       class="m-0 p-0 btn-link disabled d-inline"
       v-text="itemsText"/>
    <i class="d-block fa fa-chevron-left btn pt-0 pb-0 m-0 text-muted"
       @click="lastPage"
       :class="{'disabled':page === 1}"
       style="cursor: pointer"/>
    <p class="m-0 p-0 btn-link disabled"
       v-text="pagesText"/>
    <i class="d-block fa fa-chevron-right btn pt-0 pb-0 m-0 text-muted"
       @click="nextPage"
       :class="{'disabled':page === paginator['last_page']}"
       style="cursor: pointer"/>
    <select
        class="form-control form-control-sm form-control-border"
        style="width: 80px; border-radius: 5px"
        :value="perPage"
        @input="changePerPage">
      <option :value="option"
              :selected="perPage === option"
              :key="i"
              v-for="(option, i) in perPageOptions"
              v-text="option"/>
    </select>
  </div>
</template>

<script>
import {computed} from 'vue'

export default {
  name: "Pagination",
  props: {
    paginator: Object,
    perPage: {type: Number, default: 10},
    perPageOptions: Array,
    page: {type: Number, default: 1},
  },
  emits: ['update:page', 'update:perPage', 'reset-selected'],
  setup(props, {emit}) {
    const itemsText = computed(() => `${props.paginator['from'] ? props.paginator['from'] : 1} - ${props.paginator['to'] ? props.paginator['to'] : 1} / ${props.paginator['total'] ? props.paginator['total'] : 1}`),
        pagesText = computed(() => `${props.paginator['current_page']} of ${props.paginator['last_page']}`),
        nextPage = () => {
          if (props.page >= props.paginator.last_page) return
          emit('update:page', props.page + 1)
          emit('reset-selected', [])
        },
        lastPage = () => {
          if (props.page <= 1) return
          emit('update:page', props.page - 1)
          emit('reset-selected', [])
        },
        changePerPage = (e) => {
          emit('update:perPage', Number(e.target.value))
          emit('update:page',  1)
          emit('reset-selected', [])
        }

    return {itemsText, pagesText, nextPage, lastPage, changePerPage}
  }
}
</script>

<style scoped>

</style>