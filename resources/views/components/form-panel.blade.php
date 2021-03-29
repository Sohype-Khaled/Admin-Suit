@props(['fields', 'errors',  'id' => \Illuminate\Support\Str::slug('form-panel-' . time() )])

<div class="admin-suit-form-panel"
     id="{!! $id !!}"
     data-data="{{ json_encode($fields) }}"
     data-errors="{{ $errors->toJson() }}">
</div>

