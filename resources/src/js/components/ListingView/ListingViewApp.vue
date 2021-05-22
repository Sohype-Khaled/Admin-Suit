<template>
  <div class="d-flex mb-2">
    <!--    <v-filters-->
    <!--        :fields="fields"-->
    <!--        @input:add-filter="addFilter"-->
    <!--        :scopes="scopes"-->
    <!--        v-model:scope="scope"-->
    <!--        :filters="filters">-->
    <!--    </v-filters>-->

    <v-display-switch
        :displays="displays"
        v-model:display="display"
        @update:display="fetch">
    </v-display-switch>

    <v-actions
        :actions="bulkActions"
        :selected.sync="selected">
    </v-actions>
    <!--




        <v-search
            :scope="activeScope"
            v-model:filters="filters"
            v-model="filters['q']">
        </v-search>-->
  </div>

  <component
      :actions="itemActions"
      :is="'v'+display['component']"
      v-bind="display['attrs']"
      v-model:selected="selected"
      :with-actions="withActions"
      :fields="fields"
      :visible-fields="visibleFields">
    <template #pagination v-if="display['attrs'] && display['attrs']['withPagination'] ">
      <v-pagination
          @reset-selected="selected = []"
          v-model:page="filters['page']"
          v-model:per-page="filters['per_page']"
          :per-page-options="perPageOptions"
          :paginator="display['attrs']['meta']"/>
    </template>
  </component>
</template>

<script>
import Filters from "./Filters"
import BulkActions from "./BulkActions"
import Search from "./Search"
import Pagination from "./Pagination"
import DisplaySwitch from "./DisplaySwitch"
import TableDisplay from "./TableDisplay/TableDisplay"
import {onMounted, reactive, ref, toRef, watch} from 'vue'

export default {
  name: "ListingViewApp",
  components: {
    VFilters: Filters,
    VActions: BulkActions,
    VSearch: Search,
    VPagination: Pagination,
    VDisplaySwitch: DisplaySwitch,
    VTableDisplay: TableDisplay
  },
  props: ['initialData'],
  setup(props) {
    const perPage = toRef(props.initialData, 'per_page'),
        perPageOptions = toRef(props.initialData, 'per_page_options'),
        fields = toRef(props.initialData, 'fields'),
        scopes = toRef(props.initialData, 'scopes'),
        withActions = toRef(props.initialData, 'withActions'),
        displays = toRef(props.initialData, 'displays'),
        visibleFields = toRef(props.initialData, 'visible_fields'),
        /* defined */
        filters = reactive({dynamic: [], relationship: []}),
        initialized = ref(false),
        display = ref({}),
        scope = ref(null),
        itemActions = ref([]),
        bulkActions = ref([]),
        selected = ref([]),
        /* methods */
        getFilters = () => {
          let dynamic = [...filters.dynamic].filter(filter => filter.active).map(filter => filter.value),
              relationship = [...filters.relationship].filter(filter => filter.active).map(filter => filter.value)

          return {...filters, dynamic, relationship}
        },
        query = () => {
          let query = getFilters()
          query['class_name'] = props.initialData['className']
          query['display_type'] = display.value['component']

          // if (scope.value)
          //   query['scope'] = scope.value

          return query
        },
        fetch = async () => {
          let {
            data: {
              data,
              items_actions,
              bulk_actions
            }
          } = await $axios.get('/admin-suit/listing-view', {params: query()})

          for (let key in data)
            if (data.hasOwnProperty(key))
              display.value['attrs'][key] = data[key]

          itemActions.value = items_actions
          bulkActions.value = bulk_actions
        },
        log = (v) => console.log(v)


    onMounted(() => {
      display.value = props.initialData['display'] ? props.initialData['display'] : props.initialData['displays'][0]

      fetch()
      // console.log('fields', fields.value)
      // console.log('scopes', scopes.value)
      console.log('display', display.value)
      // console.log('displays', displays.value)
      // console.log('visibleFields', visibleFields.value)
      // console.log('withActions', withActions.value)
    })

    watch(filters, () => fetch(), {deep: true})


    return {
      perPage,
      perPageOptions,
      itemActions,
      bulkActions,
      selected,
      filters,
      fields,
      scopes,
      display,
      displays,
      visibleFields,
      withActions,
      fetch
    }
  }
}
</script>

<style scoped>

</style>