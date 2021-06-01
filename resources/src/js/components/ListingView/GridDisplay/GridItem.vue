<template>
  <div class="card mb-2" >
    <div class="card-image">
      <img src="/assets/images/explore/1.jpg" class="" alt="...">
    </div>
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center card__title">
        <div class="a-center mr-2" v-if="withActions">
          <input
              type="checkbox"
              :value="item.id"
              v-model="localValue"
              name="table_records">
        </div>
        <h6 class="text-secondary text-bold mb-0">{{item.name}}</h6>
      </div>
      <ul class="pl-0" style="min-width: 154px;">
        <li
            class="d-flex align-items-start flex-wrap"
            :class="{'flex-column': field === 'name'}"
            v-for="(field, i) in visibleFields"
            :key="i"
        >
          <p class="fw-bold mb-0">{{ field }} :</p>
          <p class="field-item mb-0 ml-1 text-secondary" >{{ item[field] ? item[field] : '-----'}}</p>
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
</template>

<script>
import SingleItemActions from "../SingleItemActions";
import {computed} from "vue";

export default {
  name: "GridItem",
  // props: ['item', 'visibleFields', 'withActions', 'actions'],
  props: {
    item: Object,
    columns: Array,
    modelValue: {type: Array, default: () => ([])},
    isEven: Boolean,
    withActions: {type: Boolean, default: false},
    actions: Object,
    visibleFields: Array
  },
  components:{
    vItemAction: SingleItemActions,
  },
  setup(props, {emit}) {
    const isSelected = computed(() => props.modelValue.includes(props.item.id)),
        localValue = computed({
          get: () => props.modelValue,
          set: v => emit('update:modelValue', v)
        })

    return {isSelected,localValue}
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
  padding-bottom: 10px;
  margin-bottom: 10px;
}
.card__title h6{
  height: calc(1.25rem * 1.1 * 1);
  text-overflow: ellipsis;
  width: 100%;
  overflow: hidden;
}
.card-image {
  min-height: 180px;
  max-height: 180px;
  overflow: hidden;
}
.card-image img{
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.card-body{
  padding: 8px 8px 60px 8px;
}

/*.field-item{*/
/*  white-space: nowrap;*/
/*}*/

.last{
  position: absolute;
  left: 8px;
  bottom: 10px;
}
@media only screen and (min-width: 1360px) {
  .field-item{
    white-space: normal;
  }
}
</style>