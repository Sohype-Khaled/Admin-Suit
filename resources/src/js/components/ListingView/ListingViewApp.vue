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

    <v-actions :actions="bulkActions"
               :selected="selected"
               :all-selected="allSelected">
    </v-actions>

    <v-search
        :scope="activeScope"
        v-model:filters="filters"
        v-model="filters['q']">
    </v-search>
  </div>

  <component
      :actions="actions"
      :is="'v'+display.component"
      v-bind="display.attrs"
      v-model:selected="selected"
      :with-actions="withActions"
      :fields="fields"
      :visible-fields="visibleFields">
    <template v-slot:pagination v-if="display.attrs.withPagination">
      <v-pagination
          :page="filters['page']"
          :per-page="filters['per_page']"
          :per-page-options="perPageOptions"
          :paginator="display.attrs.meta"
          @update:page="updatePage"
          @update:per-page="updatePerPage"/>
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
import {computed, onMounted, reactive, ref} from 'vue'

const display = ref({}),
    actions = ref([]),
    bulkActions = ref([]),
    filters = reactive({dynamic: [], relationship: []}),
    perPageOptions = ref([]),
    perPage = ref(10),
    fields = ref([]),
    visibleFields = ref([]),
    scopes = ref([]),
    scope = ref(null),
    displays = ref([]),
    selected = ref([]),
    allSelected = ref(false),
    withActions = ref(false),
    initialized = ref(false),
    activeScope = computed(() => scope.value
        ? scopes.value.find(scp => scp.name === scope.value)
        : scopes.value.find(scp => scp.name === null))

const init = data => {
      perPage.value = data['per_page']
      perPageOptions.value = data['per_page_options']
      fields.value = data['fields']
      scopes.value = data['scopes']
      withActions.value = data['withActions']
      displays.value = data['displays']
      display.value = data['display'] ? data['display'] : data['displays'][0]
      visibleFields.value = data['visible_fields']
      initialized.value = true
    },
    addFilter = filter => filters[filter.filter].push(filter),
    getFilters = () => {
      let dynamic = [...filters.dynamic].filter(filter => filter.active).map(filter => filter.value),
          relationship = [...filters.relationship].filter(filter => filter.active).map(filter => filter.value)

      return {...filters, dynamic, relationship}
    },
    updatePage = value => {
      if (value !== 1)
        filters['page'] = value
      else
        delete filters['page']
    },
    updatePerPage = value => {
      if (value !== 10)
        filters['per_page'] = value
      else
        delete filters['per_page']
    }


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
  setup({initialData}) {
    const fillDisplayData = (data) => {
          for (let key in data)
            if (data.hasOwnProperty(key))
              display.value['attrs'][key] = data[key]
        },
        query = () => {
          let query = getFilters()
          query['class_name'] = initialData['className']
          query['display_type'] = display.value['component']

          if (scope.value)
            query['scope'] = scope.value

          return query
        },
        fetch = async () => {
          let {data} = await $axios.get('/admin-suit/listing-view', {params: query()})

          fillDisplayData(data.data)

          actions.value = data['items_actions']

          bulkActions.value = data['bulk_actions']
        }

    init(initialData)
    if (initialized.value)
      fetch()

    onMounted(() => {
      console.log('Listing View Created', initialData)
    })


    return {
      //data
      filters, fields, scopes, scope, displays, display, actions, bulkActions, withActions, selected, allSelected,
      perPageOptions, perPage, visibleFields,
      // computed
      activeScope,
      //methods
      addFilter, fetch, updatePage, updatePerPage
    }
  }
}

/*export default {
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
  data() {
    return {
      initialized: false, // 0
      loading: false, // 0
      perPageOptions: [], // 1
      perPage: 10,
      filters: {
        dynamic: [],
        relationship: []
      },
      fields: [],
      visibleFields: [],
      scopes: [],
      scope: null,
      displays: [],
      display: null,
      selected: [],
      allSelected: false,
      withActions: false,
      actions: {},
      bulkActions: []
    }
  },
  computed: {
    activeScope() {
      return this.scope
          ? this.scopes.find(scope => scope.name === this.scope)
          : this.scopes.find(scope => scope.name === null)
    }
  },
  watch: {
    filters: {
      deep: true,
      handler: "fetch"
    },
    scope: "fetch",
  },
  methods: {
    addFilter(filter) {
      this.filters[filter.filter].push(filter)
    },
    updatePage(value) {
      if (value !== 1)
        this.filters['page'] = value
      else
        delete this.filters['page']
    },
    updatePerPage(value) {
      if (value !== 10)
        this.filters['per_page'] = value
      else
        delete this.filters['per_page']
    },
    init() {
      let data = this.initialData
      this.perPage = data['per_page']
      this.perPageOptions = data['per_page_options']
      this.fields = data['fields']
      this.scopes = data['scopes']
      this.withActions = data['withActions']
      this.displays = data['displays']
      this.display = data['display'] ? data['display'] : data['displays'][0]
      this.visibleFields = data['visible_fields']
      this.initialized = true
    },
    fillDisplayData(data) {
      for (var key in data)
        if (data.hasOwnProperty(key))
          this.display['attrs'][key] = data[key]
    },
    getFilters() {
      var dynamic = [...this.filters.dynamic].filter(filter => filter.active).map(filter => filter.value),
          relationship = [...this.filters.relationship].filter(filter => filter.active).map(filter => filter.value)

      return {...this.filters, dynamic, relationship}
    },
    query() {
      let query = this.getFilters()
      query['class_name'] = this.initialData['className']
      query['display_type'] = this.display.component

      if (this.scope)
        query['scope'] = this.scope

      return query
    },
    async fetch() {
      try {
        let {data} = await this.$axios.get('/admin-suit/listing-view', {params: this.query()})

        this.fillDisplayData(data.data)

        this.actions = data['items_actions']

        this.bulkActions = data['bulk_actions']

      } catch (e) {
        console.log(e)
      }
    }
  },
  setup({initialData}) {
    const display = ref([]),
        actions = ref([]),
        bulkActions = ref([]),
        filters = reactive({
          dynamic: [],
          relationship: []
        }),
        perPageOptions = ref([]),
        perPage = ref(10),
        fields = ref([]),
        visibleFields = ref([]),
        scopes = ref([]),
        scope = ref(null),
        displays = ref([]),
        selected = ref([]),
        allSelected = ref(false),
        withActions = ref(false)

    const fillDisplayData = (data) => {
          for (let key in data)
            if (data.hasOwnProperty(key))
              display['attrs'][key] = data[key]
        },
        query = () => {

        },
        fetch = async () => {
          try {
            let {data} = await $axios.get('/admin-suit/listing-view', {params: {}})

            fillDisplayData(data.data)

            actions.value = data['items_actions']

            bulkActions.value = data['bulk_actions']

          } catch (e) {
            console.log(e)
          }
        }

    fetch()

    onMounted(() => {
      console.log('Listing View Created', initialData)
    })


    return {}
    // this.init()
    // if (this.initialized)
    //   this.fetch()
    // console.log('Listing View Created', this.initialData)
  }
}*/
</script>

<style scoped>

</style>