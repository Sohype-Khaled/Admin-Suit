<template>
  <div class="card mb-2" >
    <div class="card-image">
      <img src="/assets/images/explore/1.jpg" class="" alt="...">
    </div>
    <div class="card-body">
      <div class="d-flex justify-content-between card__title">
        <h6 class="text-secondary text-bold">{{item.name}}</h6>
      </div>
      <ul class="pl-0" style="min-width: 154px;">
        <li
            class="d-flex align-items-start flex-wrap"
            v-for="(field, i) in visibleFields"
            :key="i"
        >
          <p class="fw-bold mb-0">{{ field }} :</p>
          <p class="mb-0 ml-1 text-secondary" >{{ item[field]}}</p>
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

export default {
  name: "GridItem",
  props: ['item', 'visibleFields', 'withActions', 'actions'],
  components:{
    vItemAction: SingleItemActions,
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

.last{
  position: absolute;
  left: 15px;
  bottom: 10px;
}

</style>