<template>
  <div class="lv-search-filters">
    <div class="lv-search-filters__filters">
      <div class="lv-search-filters__filter"> {{ 'Scope: ' + scope.title }}</div>
      <div v-for='(filter, i) in dynamicFilters' :key='filter' class='lv-search-filters__filter'>
        {{ filter.label }}
        <i class="fa fa-times" @click="disableFilter(filter.filter, filter.value)"></i>
      </div>
    </div>
    <input type="text"
           placeholder="Search..."
           :value="filters['q']"
           @change="$emit('update:modelValue', $event.target.value)"
           class='lv-search-filters__search'/>
  </div>
</template>

<script>
export default {
  name: "Search",
  props: {
    scope: Object,
    filters: Object,
    modelValue: String
  },
  emits: ['update:modelValue', 'update:filters'],
  computed: {
    dynamicFilters() {
      return [
          ...this.filters.dynamic,
        ...this.filters.relationship
      ].filter(filter => filter.active)
    }
  },
  methods: {
    disableFilter(filter, value) {
      let filters = {...this.filters},
          found = filters[filter].find(filter => filter.value === value)
      if (found)
        found.active = false

      this.$emit('update:filters', filters)
    }
  },
}
</script>
