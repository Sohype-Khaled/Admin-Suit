<template>
  <div class="fixed-menu dropdown">
    <button type="button" class="btn btn-outline-info btn-sm dropdown-toggle"
            style="height: 100%">
      Filters
      <i class="fa fa-filter"></i>
    </button>
    <div class="dropdown-menu fixed-menu__menu">
      <div
          class="dropdown-item"
          :key="i"
          v-for="(loopScope, i) in scopes">
        <div class="form-check form-check-inline mb-1">
          <input class="form-check-input"
                 type="radio"
                 name="scope"
                 :checked="scope === loopScope['name']"
                 :id="i+'-'+ loopScope['name']"
                 :value="loopScope['name']"
                 @change="$emit('update:scope', $event.target.value)">
          <label class="form-check-label"
                 :for="i+'-'+ loopScope['name']"
                 v-text="loopScope['title']"/>
        </div>
      </div>
      <div
          class="dropdown-item"
          :key="i"
          v-for="(filter, i) in dynamicFilters">
        <div class="form-check form-check-inline mb-1">
          <input class="form-check-input"
                 type="checkbox"
                 name="filter"
                 :id="filter['value']"
                 v-model="dynamicFilters[i].active">
          <label class="form-check-label"
                 :for="i+'-'+ filter['value']"
                 v-text="filter['label']"/>
        </div>
      </div>
      <div
          class="dropdown-item"
          :key="i"
          v-for="(filter, i) in relationshipFilters">
        <div class="form-check form-check-inline">
          <input class="form-check-input"
                 type="checkbox"
                 name="filter"
                 :id="filter['value']"
                 v-model="dynamicFilters[i].active">
          <label class="form-check-label"
                 :for="filter['value']"
                 v-text="filter['label']"/>
        </div>
      </div>
      <div class="dropdown-divider"></div>
      <div class="dropdown-item">
        <div class="input-group input-group-sm d-flex flex-column">
          <select
              class="form-control form-control-sm form-control-border rounded-0 filter-form__select "
              style="width: 100%"
              v-model="field">
            <option :value="option.attrs['name']?option.attrs['name']: option.attrs['relationship']"
                    :key="i"
                    v-for="(option, i) in availableFields"
                    v-text="option.attrs['label']"/>
          </select>
          <select
              v-model="operator"
              :disabled="!field"
              style="width: 100%"
              class="form-control form-control-sm form-control-border rounded-0 filter-form__select">
            <option :value="operator['name']"
                    :key="i"
                    v-for="(operator, i) in selectedField['operators']"
                    v-text="operator['title']"/>
          </select>
          <template v-if="selectedOperator">
            <component
                style="width: 100%"
                v-model="output[i]"
                :field="selectedField"
                :operator="selectedOperator"
                v-bind="{...selectedField['attrs']}"
                :is="'v' +selectedField.component"
                :key="i"
                v-for="(arg, i) in selectedOperator['number_of_argument']">
            </component>
          </template>
          <span class="input-group-append">
							<button
                  style="width: 100%"
                  :disabled="field===''||operator===''||output.length === 0"
                  type="button"
                  class="btn btn-info btn-flat rounded-0 m-0"
                  @click="addFilter">Go!</button>
						</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Filters",
  props: {
    fields: Array,
    modelValue: Object,
    scopes: Array,
    scope: {type: String, default: null},
    filters: Object
  },
  // components: {lvSelect: select,},
  data() {
    return {
      field: '',
      operator: '',
      output: [],
      open: false
    }
  },
  computed: {
    availableFields() {

      let fields = []

      for (let field of this.fields) {

        if (field.relationship)
          for (let rField of field.fields)
            fields.push({
              ...rField,
              title: field.title + ' ' + rField.title,
              name: field.name + '.' + rField.name,
              relationship: field.name,
            })
        fields.push(field)

      }

      return fields
    },
    selectedField() {
      if (!this.field) return {}
      return this.availableFields.find(field => field.attrs.name === this.field)
    },
    selectedOperator() {
      if (Object.keys(this.selectedField).length <= 0) return {}
      return this.selectedField.operators.find(operator => operator.name === this.operator)
    },
    dynamicFilters() {
      return this.filters.dynamic
    },
    relationshipFilters() {
      return this.filters.relationship
    }
  },
  emits: ['update:scope', 'input:add-filter'],
  methods: {
    reset() {
      this.field = ''
      this.operator = ''
      this.output = []
    },
    addFilter() {
      this.$emit('input:add-filter', {
        filter: this.selectedField.attrs.relationship ? 'relationship' : 'dynamic',
        label: toTitleCase(this.selectedField.attrs.label) + ' ' +
            toTitleCase(this.selectedOperator.title) + ' ' +
            [...this.output].map(w => toTitleCase(w)).join(' and '),
        value: this.field + '-' + this.operator + '-' + [...this.output].join(','),
        active: true
      })
      this.reset()
    }
  },
}
</script>

<style scoped>

</style>