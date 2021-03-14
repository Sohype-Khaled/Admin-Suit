@props(['data', 'id' => \Illuminate\Support\Str::slug($data->model . '-' . time() )])

<div class="listing-view" id="{!! $id !!}" data-data='{!! json_encode($data) !!}' @verbatim>
    <div class="d-flex">
        <lv-filters
                :fields="fields"
                @input:add-filter="addFilter"
                :scopes="scopes"
                v-model:scope="scope"
                :filters="filters"></lv-filters>

        <div class="btn-group">
            <button type="button" class="btn btn-outline-info btn-sm">
                <i class="fa fa-th"></i>
            </button>
            <button type="button" class="btn btn-outline-info btn-sm">
                <i class="fa fa-list"></i>
            </button>
        </div>


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


    <lv-table
            v-model:selected="selected"
            :with-actions="withActions"
            :scope="activeScope"
            :columns="fields"
            :items="items">

        <template v-slot:pagination>
            <lv-pagination
                    :page="filters['page']"
                    :per-page="filters['per_page']"
                    :per-page-options="perPageOptions"
                    :paginator="meta"
                    @update:page="updatePage"
                    @update:per-page="updatePerPage"/>
        </template>
        <template v-slot:default="{item, columns, isEven}">
            <lv-table-row
                    :actions="actions"
                    :with-actions="withActions"
                    :is-even="isEven"
                    :item="item"
                    :columns="columns"
                    v-model="selected"/>
        </template>
    </lv-table>
</div>
@endverbatim