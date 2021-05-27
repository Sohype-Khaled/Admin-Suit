<template>
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="my-2 d-flex align-items-center">
          <div class="d-flex justify-content-between align-items-center mr-2" style="width: 30px">
            <input
                @change="updateAllSelected"
                v-model="isAllSelected"
                type="checkbox"
                class="mr-2">
            <v-field-activator :columns="columns" v-model="visibleFields"/>
          </div>
          <p
            v-for="(column, i) in visibleColumns"
            :key="i"
            v-text="column['attrs']['label']"
            class="mx-2 mb-0"
          />
        </div>
      </div>
      <template v-if=" $attrs.items.length > 0">
        <div class="col-lg-4" v-for="(item, i) in $attrs.items" :key="i">
        <div class="card mb-2" >
          <div class="card-image">
            <img src="/assets/images/explore/1.jpg" class="" alt="...">
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-between card__title">
              <h5 class="text-secondary text-bold">{{item.name}}</h5>
            </div>
            <ul class="pl-0" style="min-width: 154px;">
              <li
                  class="d-flex align-items-start flex-wrap"
                  v-for="(field, i) in visibleFields"
                  :key="i"
              >
                <h6 class="fw-bold mr-1">{{ field }} :</h6>
                <span class="" >{{ item[field]}}</span>
              </li>
            </ul>
            <div class="last mt-auto" v-if="withActions">
              <v-item-action :actions="actions[item['id']]">
                <template v-slot:activator>
                  <a class="btn btn-secondary" href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                   Actions <i class="fa fa-chevron-down"></i>
                  </a>
                </template>
              </v-item-action>
            </div>
          </div>
        </div>
      </div>
      </template>
      <div v-else>
        there is no items
      </div>
    </div>
  </div>
<!--  {{visibleFields}}-->
<!--  {{visibleColumns}}-->
<!--  <div v-for=""></div>-->
</template>

<script>
import FieldActivator from "../FieldActivator"
import {computed, onMounted, ref, toRef, watch} from "vue";
import SingleItemActions from "../SingleItemActions";

export default {
  name: "GridDisplay",
  inheritAttrs: false,
  components: {
    vFieldActivator: FieldActivator,
    vItemAction: SingleItemActions
  },
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
.card{
  height: calc(100% - 20px);
  position: relative;
}
.card__title{
  border-bottom: 1px solid rgba(0, 0, 0, 0.125);
  margin-bottom: 10px;
}
.card__title h5{
  height: calc(1.25rem * 1.2 * 2);
  overflow: hidden;
  text-overflow: ellipsis;
}
.card-image {
  min-height: 250px;
  max-height: 250px;
  overflow: hidden;
}
.card-image img{
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.card-body{
  padding-bottom: 50px;
}

.last{
  position: absolute;
  left: 20px;
  bottom: 10px;
}
</style>