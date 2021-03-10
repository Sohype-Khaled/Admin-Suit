const fillPlaceholders = function(pathPattern, values = {}) {
        const matches = pathPattern.match(/:[a-z]+/gi);
        if (!matches) {
            return pathPattern;
        }

        // Get a list of unique placeholders
        const placeholders = matches.filter(
            (value, index, self) => self.indexOf(value) === index
        );

        // Sort the placeholders by length descending, so that we'll fill the longest
        // ones first (avoiding bugs like if there are :id and :idea)
        placeholders.sort((a, b) => b.length - a.length);

        // Loop through placeholders and replace them
        return placeholders.reduce((outputPath, placeholder) => {
            const value = values[placeholder.substring(1)];
            if (value == null) {
                throw new Error(`Missing value for ${placeholder}`);
            }
            return outputPath.replace(new RegExp(placeholder, "g"), value);
        }, pathPattern);
    },
    toTitleCase = function(str) {
        return str[0].toUpperCase() + str.slice(1);
    };

const search = {
    props: {
        scope: Object,
        filters: Object,
        modelValue: String,
    },
    emits: ["update:modelValue", "update:filters"],
    computed: {
        dynamicFilters() {
            return [...this.filters.dynamic, ...this.filters.relationship].filter(
                (filter) => filter.active
            );
        },
    },
    methods: {
        disableFilter(filter, value) {
            var filters = {...this.filters },
                found = filters[filter].find((filter) => filter.value === value);
            if (found) found.active = false;

            this.$emit("update:filters", filters);
        },
    },
    template: `
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
</div>`,
};

const pagination = {
    props: {
        paginator: Object,
        perPage: {
            type: Number,
            default: 10,
        },
        perPageOptions: Array,
        page: {
            type: Number,
            default: 1,
        },
    },
    computed: {
        localPage: {
            get() {
                return this.page;
            },
            set(value) {
                this.$emit("update:page", value);
            },
        },
        localPerPage: {
            get() {
                return this.perPage;
            },
            set(value) {
                this.$emit("update:per-page", value);
            },
        },
        itemsText() {
            return `${this.paginator["from"] ? this.paginator["from"] : 1} - ${
        this.paginator["to"] ? this.paginator["to"] : 1
      } / ${this.paginator["total"] ? this.paginator["total"] : 1}`;
        },
        pagesText() {
            return `${this.paginator["current_page"]} of ${this.paginator["last_page"]}`;
        },
    },
    emits: ["update:page", "update:per-page"],
    template: `
<div class="d-flex align-items-center">
<a href="javascript:void(0)" class="btn btn-link disabled d-inline">{{ itemsText }}</a>
<a href="javascript:void(0)"
   @click="localPage--"
   :class="{'disabled':localPage === 1}"
   class="btn btn-link text-muted">
  <i class="fa fa-chevron-left"></i>
</a>
<a class="btn btn-link disabled">{{ pagesText }}</a>
<a href="javascript:void(0)"
   @click="localPage++"
   :class="{'disabled':localPage === paginator['last_page']}"
   class="btn btn-link text-muted">
  <i class="fa fa-chevron-right"></i>
</a>
<select
    class="form-control form-control-sm form-control-border"
    style="width: 50px"
    v-model="localPerPage">
  <option :value="option"
          :selected="perPage === option"
          :key="i"
          v-for="(option, i) in perPageOptions"
          v-text="option"/>
</select>
</div>`,
};

const select = {
    name: "LvSelect",
    props: {
        modelValue: String | Number,
        options: Array,
        item_text: { type: String, default: "text" },
        item_value: { type: String, default: "value" },
        ajax: { type: Boolean, default: false },
    },
    data() {
        return {
            ajaxOptions: [],
        };
    },
    emit: ["update:modelValue"],
    computed: {
        localOptions() {
            return this.ajax ? this.ajaxOptions : this.options;
        },
    },
    async created() {
        let { data } = await this.$axios.get("/admin/one2many", {
            params: { model: this.$attrs.field.model },
        });
        this.ajaxOptions = data.data;
    },
    methods: {
        async getOptions() {
            console.log(this.$attrs.field.model);
            let { data } = await this.$axios.get("/admin/one2many", {
                params: { model: this.$attrs.field.model },
            });
            console.log(data.data);
            return data.data;
        },
    },
    template: `
<select @input="$emit('update:modelValue', $event.target.value)">
<option
    :key="i"
    :value="option[item_value]"
    v-for="(option, i) in localOptions"
    v-text="option[item_text]"/>
</select>
`,
};

const filters = {
    props: {
        fields: Array,
        modelValue: Object,
        scopes: Array,
        scope: { type: String, default: null },
        filters: Object,
    },
    components: { lvSelect: select },
    data() {
        return {
            field: "",
            operator: "",
            output: [],
        };
    },
    computed: {
        availableFields() {
            var fields = [];
            for (var field of this.fields) {
                if (field.relationship)
                    for (var rField of field.fields)
                        fields.push({
                            ...rField,
                            title: field.title + " " + rField.title,
                            name: field.name + "." + rField.name,
                            relationship: field.name,
                        });
                fields.push(field);
            }
            return fields;
        },
        selectedField() {
            if (!this.field) return {};
            return this.availableFields.find((field) => field.name === this.field);
        },
        selectedOperator() {
            if (Object.keys(this.selectedField).length <= 0) return {};
            return this.selectedField.operators.find(
                (operator) => operator.name === this.operator
            );
        },
        dynamicFilters() {
            return this.filters.dynamic;
        },
        relationshipFilters() {
            return this.filters.relationship;
        },
    },
    emits: ["update:scope", "input:add-filter"],
    methods: {
        reset() {
            this.field = "";
            this.operator = "";
            this.output = [];
        },
        addFilter() {
            this.$emit("input:add-filter", {
                filter: this.selectedField.relationship ? "relationship" : "dynamic",
                label: toTitleCase(this.selectedField.title) +
                    " " +
                    toTitleCase(this.selectedOperator.title) +
                    " " + [...this.output].map((w) => toTitleCase(w)).join(" and "),
                value: this.field + "-" + this.operator + "-" + [...this.output].join(","),
                active: true,
            });
            this.reset();
        },
    },
    template: `
<div>
<div class="form-check form-check-inline"
     :key="i"
     v-for="(loopScope, i) in scopes">
  <input class="form-check-input"
         type="radio"
         name="scope"
         :checked="scope === loopScope['name']"
         :id="'scope' + loopScope['name']"
         :value="loopScope['name']"
         @change="$emit('update:scope', $event.target.value)">
  <label class="form-check-label" :for="'scope' + loopScope['name']">{{ loopScope['title'] }}</label>
</div>
<div class="form-check form-check-inline"
     :key="i"
     v-for="(filter, i) in dynamicFilters">
  <input class="form-check-input"
         type="checkbox"
         name="filter"
         :id="'dynamic' + filter['value']"
         v-model="dynamicFilters[i].active">
  <label class="form-check-label" :for="'dynamic' + filter['value']">{{ filter['label'] }}</label>
</div>
<div class="form-check form-check-inline"
     :key="i"
     v-for="(filter, i) in relationshipFilters">
  <input class="form-check-input"
         type="checkbox"
         name="filter"
         :id="'relationship' + filter['value']"
         v-model="dynamicFilters[i].active">
  <label class="form-check-label" :for="'relationship' + filter['value']">{{ filter['label'] }}</label>
</div>
<div class="form-group">
  <div class="input-group input-group-sm">
    <select
        class="form-control form-control-sm form-control-border rounded-0"
        v-model="field">
      <option :value="option['name']?option['name']: option['relationship']"
              :key="i"
              v-for="(option, i) in availableFields"
              v-text="option['title']"/>
    </select>
    <select
        v-model="operator"
        :disabled="!field"
        class="form-control form-control-sm form-control-border rounded-0">
      <option :value="operator['name']"
              :key="i"
              v-for="(operator, i) in selectedField['operators']"
              v-text="operator['title']"/>
    </select>
    <template v-if="selectedOperator">
      <component
          :value="output[i]"
          @input="output[i] = $event.target.value"
          :field="selectedField"
          :operator="selectedOperator"
          class="form-control form-control-sm form-control-border rounded-0"
          v-bind="{...selectedField['argument_component']['attrs'], options: selectedField['options']}"
          :is="selectedField['argument_component']['component']"
          :key="i"
          v-for="(arg, i) in selectedOperator['number_of_argument']">
      </component>
    </template>
    <span class="input-group-append">
                <button
          :disabled="field===''||operator===''||output.length === 0"
          type="button"
          class="btn btn-info btn-flat rounded-0"
          @click="addFilter">Go!</button>
            </span>
  </div>
</div>
</div>
`,
};

const fieldLinkMixin = {
        props: {
            field: Object,
            item: Object,
        },
        methods: {
            replace() {
                if (!this.field["withLink"]) return;
                return fillPlaceholders(this.field["link"], this.item);
            },
        },
    },
    textFieldCell = {
        name: "TextFieldCell",
        mixins: [fieldLinkMixin],
        template: `
  <td>
  <a :href="replace()"
     v-if="field['withLink']"
     v-text="item[field.name]"/>
  <span v-else v-text="item[field.name]"/>
  </td>`,
    },
    optionsFieldCell = {
        name: "OptionsFieldCell",
        mixins: [fieldLinkMixin],
        computed: {
            text() {
                return this.field.options.find(
                    (option) => option.value === this.item[this.field.name]
                ).text;
            },
        },
        template: `
  <td>
  <a :href="replace()"
     v-if="field['withLink']"
     v-text="text"/>
  <span v-else v-text="text"/>
  </td>`,
    },
    numberFieldCell = {
        name: "NumberFieldCell",
        mixins: [fieldLinkMixin],
        template: `
  <td>
  <a :href="replace()"
     v-if="field['withLink']"
     v-text="item[field.name]"/>
  <span v-else v-text="item[field.name]"/>
  </td>`,
    },
    booleanFieldCell = {
        name: "BooleanFieldCell",
        mixins: [fieldLinkMixin],
        template: `
  <td>
  <i :class="[item[field.name]? 'glyphicon-ok': 'glyphicon-remove']"
     class="glyphicon"/>
  </td>`,
    },
    dateTimeFieldCell = {
        name: "DateTimeFieldCell",
        mixins: [fieldLinkMixin],
        computed: {
            datetimeValue() {
                if (!this.item[this.field.name]) return "______";
                return moment(this.item[this.field.name]).format(this.field.format);
            },
        },
        template: `
  <td>
  <a :href="replace()"
     v-if="field['withLink']"
     v-text="datetimeValue"/>
  <span v-else v-text="datetimeValue"/>
  </td>`,
    },
    belongsToFieldCell = {
        name: "BelongsToFieldCell",
        mixins: [fieldLinkMixin],
        template: `
  <td>
  <a :href="replace()" v-if="field['withLink']"
     v-text="item[field['name']][field['related_column']]"/>
  <span v-else v-text="item[field['name']][field['related_column']]"/>
  </td>`,
    };

const tableRow = {
    props: {
        item: Object,
        columns: Array,
        value: Array,
        isEven: Boolean,
    },
    components: {
        lvTextField: textFieldCell,
        lvDateTimeField: dateTimeFieldCell,
        lvBelongsToField: belongsToFieldCell,
        lvNumberField: numberFieldCell,
        lvBooleanField: booleanFieldCell,
        lvOptionsField: optionsFieldCell,
    },
    computed: {
        isSelected() {
            return this.value.includes(this.item.id);
        },
        localValue: {
            get() {
                return this.value;
            },
            set(value) {
                this.$emit("input", value);
            },
        },
    },
    methods: {
        change($event) {
            // this.$emit('update:modelValue', $event.target.value)
        },
    },
    template: `
<tr :class="[isEven? 'even': 'odd', ' pointer ', {' selected' : isSelected}]">
<td class="a-center">
  <input
      type="checkbox"
      :value="item.id"
      v-model="localValue"
      name="table_records">
</td>
<!-- <component
    :field="column"
    :item="item"
    :is="'lv'+column['component']"
    :key="i"
    v-for="(column, i) in columns"/> -->
</tr>`,
};

const tableView = {
    props: {
        items: Array,
        columns: Array,
        scope: Object,
        selected: { type: Array, default: () => [] },
    },
    components: {
        lvTableRow: tableRow,
    },
    data() {
        return {
            allSelected: false,
            visible: [],
        };
    },
    computed: {
        scopeColumns() {
            return this.columns.map((column) => {
                return {
                    isVisible: this.visible.includes(column.name),
                    ...column,
                };
            });
        },
        shownColumns() {
            return this.scopeColumns.filter((column) => {
                return column.isVisible;
            });
        },
    },
    watch: {
        scope: {
            immediate: true,
            handler(value) {
                this.visible = [...value.columns];
            },
        },
    },
    emits: ["update:selected"],
    template: `
<div class="table-responsive">
<div class="form-check form-check-inline"
     :key="i"
     v-for="(column, i) in columns">
  <input class="form-check-input"
         type="checkbox"
         :id="column['name']"
         :value="column['name']"
         v-model="visible">
  <label class="form-check-label" :for="column['name']">{{ column['title'] }}</label>
</div>
<table class="table table-striped jambo_table bulk_action">
  <thead>
  <tr class="headings">
    <th>
      <input type="checkbox" id="check-all">
    </th>
    <th :colspan="columns.length" v-if="selected.length > 0">
      <span style="font-weight: 500">Bulk Actions ( {{ selected.length }} Records Selected )</span>
    </th>
    <template v-else>
      <th :class="{'sortable': column.sortable, }"
          class="column-title"
          :key="i"
          v-show="column.isVisible"
          v-for="(column, i) in shownColumns"
          v-text="column['title']"/>
    </template>
  </tr>
  </thead>
  <tbody>
  <template :key="i" v-for="(item, i) in items">
    <lv-table-row
        :is-even="i % 2===0"
        :item="item"
        :columns="shownColumns"
        :value="selected"
        @input="$emit('update:selected', $event.target.value)"/>
  </template>
  </tbody>
</table>
</div>`,
};

const ListingView = {
    props: ["initialData"],
    components: {
        lvPagination: pagination,
        lvTable: tableView,
        lvFilters: filters,
        lvSearch: search,
    },
    data() {
        return {
            loading: false,
            perPageOptions: [],
            meta: {},
            filters: {
                dynamic: [],
                relationship: [],
            },
            items: [],
            fields: [],
            scopes: [],
            scope: null,
            selected: [],
        };
    },
    computed: {
        activeScope() {
            return this.scope ?
                this.scopes.find((scope) => scope.name === this.scope) :
                this.scopes.find((scope) => scope.name === null);
        },
    },
    watch: {
        filters: {
            deep: true,
            handler: "fetch",
        },
        scope: "fetch",
    },
    methods: {
        addFilter(filter) {
            this.filters[filter.filter].push(filter);
        },
        updatePage(value) {
            if (value !== 1) this.filters["page"] = value;
            else delete this.filters["page"];
        },
        updatePerPage(value) {
            if (value !== 10) this.filters["per_page"] = value;
            else delete this.filters["per_page"];
        },
        init() {
            let data = this.initialData;
            this.perPage = data["per_page"];
            this.perPageOptions = data["per_page_options"];
            this.fields = data["fields"];
            this.scopes = data["scopes"];
        },
        getFilters() {
            var dynamic = [...this.filters.dynamic]
                .filter((filter) => filter.active)
                .map((filter) => filter.value),
                relationship = [...this.filters.relationship]
                .filter((filter) => filter.active)
                .map((filter) => filter.value);

            return {...this.filters, dynamic, relationship };
        },
        query() {
            let query = this.getFilters();
            query["model"] = this.initialData["model"];
            query["class_name"] = this.initialData["className"];
            if (this.scope) query["scope"] = this.scope;
            return query;
        },
        async fetch() {
            try {
                let { data } = await this.$axios.get("/admin-suit/listing-view", {
                    params: this.query(),
                });
                this.meta = data.meta;
                this.items = data.items;
            } catch (e) {
                console.log(e);
            }
        },
    },
    created() {
        this.init();
        this.fetch();
        console.log("Listing View Created", this.initialData);
    },
};

$(".listing-view").each(function(i, lv) {
    var lv = $(lv),
        id = lv.attr("id"),
        data = lv.data("data"),
        app = Vue.createApp(ListingView, { initialData: data });
    app.config.globalProperties.$axios = axios;
    app.mount(`#${id}`);
});