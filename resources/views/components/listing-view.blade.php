@props(['data', 'id' => \Illuminate\Support\Str::slug('lv-' . time() )])

<div class="listing-view" id="{!! $id !!}" data-data="{{ json_encode($data) }}"></div>