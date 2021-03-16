@props(['fields', 'errors',  'id' => \Illuminate\Support\Str::slug('form-panel-' . time() )])

<div class="admin-suit-form-panel"
     id="{!! $id !!}"
     data-data='{{ json_encode($fields) }}' @verbatim>

    <component
            v-model="localForm[input.attrs.name]"
            v-bind="input.attrs"
            :is="'v' + input.component"
            :key="i"
            v-for="(input, i)  in fields"/>

</div>
@endverbatim