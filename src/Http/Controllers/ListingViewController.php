<?php

namespace Codtail\AdminSuit\Http\Controllers;

use Codtail\AdminSuit\Support\RelationshipFieldAbstract;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class ListingViewController extends Controller
{

    public $list_view, $scope;

    public function index(Request $request)
    {

        $list_view = $request->input('class_name');

        $this->list_view = new $list_view();

        if ($request->has('scope'))
            $this->list_view->setScope($request->input('scope'));

//        dd($request->input('display_type'));


        $query = $this->list_view->searchable ? $this->list_view->model : $this->list_view->model::query();

        $data = app(Pipeline::class)
            ->send($query)
            ->through($this->list_view->getFilters())
            ->thenReturn();

        $data = $data->with(($this->getRelationships()));

        $this->list_view->setDisplay($request->input('display_type'));
        $display = $this->list_view->getDisplay()['attrs']->resolve($data);

        return response()->json([
            'data' => $display->response(),
            'items_actions' => $this->getItemActions($display->items),
            'bulk_actions' => $this->getBulkActions($this->list_view->model)
        ]);
//
//        if ($this->list_view->pagination)
//            $data = $data->paginate($per_page)
//                ->fragment('per_page');
//        else
//            $data = $data->get();


        /* return response()->json([
             'meta' => $this->getMeta($data->toArray()),
             'items' => $data->items(),
             'items_actions' => $this->getItemActions($data->items()),
             'bulk_actions' => $this->getBulkActions($model)
         ]);*/
    }

    private function getRelationships()
    {
        $relationships = [];

        foreach ($this->list_view->fields as $field)
            if ($field instanceof RelationshipFieldAbstract)
                $relationships[] = $field->name;

        return $relationships;
    }

    private function getItemActions($items)
    {
        $actions = [];
        foreach ($items as $item) {
            foreach ($this->list_view->getActions() as $action) {
                if ($action_data = $action->resolveModelAction($item))
                    $actions[$item->id][] = $action_data;
            }
        }
        return $actions;
    }

    private function getBulkActions($model)
    {
        $actions = [];
        foreach ($this->list_view->getActions() as $action) {
            $action_refliction = new \ReflectionClass(get_class($action));
            if ($action_refliction->hasMethod('resolveBulkActions')
                && $action_data = $action->resolveBulkActions($model))
                $actions[] = $action_data;
        }

        return $actions;
    }

    private function getMeta($paginator)
    {
        return [
            'current_page' => $paginator['current_page'],
            'first_page' => 1,
            'last_page' => $paginator['last_page'],
            'from' => $paginator['from'],
            'to' => $paginator['to'],
            'total' => $paginator['total'],
            'per_page' => $paginator['per_page']
        ];
    }
}
