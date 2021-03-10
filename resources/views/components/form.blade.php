@props($['method' => 'get',
'action' => '',
'hasFiles' => false,
'id' => \Illuminate\Support\Str::slug($data->model . '-' . time() )
])


<form action="{{ $action }}" id="{!! $id !!}"
    method="{{ in_array($method, ['get', 'post']) ? $method : 'post' }}" {!! $hasFiles ? 'enctype="multipart/form-data"' : '' !!}>
    @csrf
    @if (!in_array($method, ['get', 'post'])) @method($method) @endif

    {{ $slot }}
</form>
