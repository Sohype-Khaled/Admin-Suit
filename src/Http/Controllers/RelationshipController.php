<?php

namespace Codtail\AdminSuit\Http\Controllers;

use Illuminate\Http\Request;

class RelationshipController extends Controller
{
    public function __invoke(Request $request)
    {
        $model = $request->input('model');

        $result =  app(Pipeline::class)
            ->send($model)
            ->through($this->getFilters())
            ->thenReturn()->get();

        return RelationsResource::collection($result);
    }
}
