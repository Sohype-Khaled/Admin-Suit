@props(['actions', 'id' => \Illuminate\Support\Str::slug('model-actions-' . time() )])
<div class="admin-suit-model-actions" id="{!! $id !!}" data-data='{!! json_encode($actions) !!}' @verbatim>
    <admin-suit-actions :actions="actions">
        <template v-slot:activator>
            <button type="button" class="btn m-0 btn-info" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Actions
                <i class="fa fa-chevron-down"></i>
            </button>
        </template>
    </admin-suit-actions>
</div>
@endverbatim