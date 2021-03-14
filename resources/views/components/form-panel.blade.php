@props(['fields', 'id' => \Illuminate\Support\Str::slug('form-panel-' . time() )])

<div class="admin-suit-form-panel"
     id="{!! $id !!}"
     data-data='{{ json_encode($fields) }}' @verbatim>

    <component
            :is="'v' + input.component"
            :key="i"
            v-for="(input, i)  in fields"
            v-bind="input.attrs"/>
</div>
@endverbatim