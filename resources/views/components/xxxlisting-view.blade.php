@props(['data', 'id' => \Illuminate\Support\Str::slug('lv-' . time() )])

<div class="listing-view" id="{!! $id !!}" data-data='{!! json_encode($data) !!}' @verbatim>
    <div class="d-flex mb-2">
        <lv-filters
                :fields="fields"
                @input:add-filter="addFilter"
                :scopes="scopes"
                v-model:scope="scope"
                :filters="filters">
        </lv-filters>

        <v-display-buttons
                :displays="displays"
                v-model:display="display"
                @update:display="fetch">
        </v-display-buttons>

        <lv-actions :actions="bulkActions"
                    :selected="selected"
                    :all-selected="allSelected">
        </lv-actions>

        <lv-search
                :scope="activeScope"
                v-model:filters="filters"
                v-model="filters['q']">
        </lv-search>
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
            <lv-pagination
                    :page="filters['page']"
                    :per-page="filters['per_page']"
                    :per-page-options="perPageOptions"
                    :paginator="display.attrs.meta"
                    @update:page="updatePage"
                    @update:per-page="updatePerPage"/>
        </template>
    </component>
</div>
@endverbatim