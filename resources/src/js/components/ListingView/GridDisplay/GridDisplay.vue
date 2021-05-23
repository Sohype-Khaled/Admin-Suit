<template>
  image
  fields
  actions
  <div class="container">
    <div class="row">
      <div class="col-lg-3">
        <div class="card mb-2">
          <div class="card-image">
            <img src="/assets/images/explore/1.jpg" class="" alt="...">
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-between card__title">
              <h4 class="text-secondary text-bold">product name</h4>
              <div class="dropdown">
                <button class="btn dropdown-toggle p-0 grid-item__btn-action" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-ellipsis-h"></i>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                  <li><a class="dropdown-item" href="#">Action</a></li>
                  <li><a class="dropdown-item" href="#">Another action</a></li>
                  <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
              </div>
            </div>
            <li class="d-flex align-items-start">
              <h6 class="fw-bold">Field name :</h6>
              <span class="px-2" >value</span>
            </li>
            <li class="d-flex align-items-start">
              <h6 class="fw-bold">Field name :</h6>
              <span class="px-2" >value</span>
            </li>
            <li class="d-flex align-items-start">
              <h6 class="fw-bold">Field name :</h6>
              <span class="px-2" >value</span>
            </li>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {computed, onMounted, ref, toRef, watch} from "vue";

export default {
  name: "GridDisplay",
  inheritAttrs: false,
  props: {
    fields: Array,
    visibleFields: Array,
    selected: Array,
    withActions: {type: Boolean, default: false},
    actions: Object,
  },
  setup(props, {emit, attrs}) {
    const visibleFields = ref([]),
        isAllSelected = ref(false),
        selected = toRef(props, 'selected'),
        fields = toRef(props, 'fields'),
        columns = computed(() => fields.value.map(({attrs, component}) => ({
          component, attrs, visible: visibleFields.value.includes(attrs.name)
        }))),
        visibleColumns = computed(() => columns.value.filter(column => column.visible)),
        updateAllSelected = () => (isAllSelected.value ? emit('update:selected', attrs.items.map(item => item.id)) : emit('update:selected', []))

    watch(selected, (v) => {
      let items = attrs.items.map(item => item.id).slice().sort(),
          val = v.slice().sort()
      isAllSelected.value = val.length === items.length && val.every((item, idx) => item === items[idx]);
      emit('update:selected', v)
    })

    onMounted(() => {
      visibleFields.value = [...props.visibleFields]
    })
    return {visibleColumns, columns, visibleFields, isAllSelected, updateAllSelected}
  }
}
</script>

<style scoped>
.card__title{
  //border-bottom: rgba(#ccc, 0.4);
  border-bottom: 1px solid rgba(0, 0, 0, 0.125);
  margin-bottom: 10px;
}
.card-image {
  height: 250px;
  overflow: hidden;
}
.card-image img{
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.grid-item__btn-action::after{
  display: none;
}
</style>