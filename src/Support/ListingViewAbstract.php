<?php


namespace Codtail\AdminSuit\Support;


use Codtail\AdminSuit\Support\Filters\DynamicFilter;
use Codtail\AdminSuit\Support\Filters\QFilter;
use Codtail\AdminSuit\Support\Filters\RelationshipFilter;
use Illuminate\Database\Eloquent\Model;

abstract class ListingViewAbstract
{
    public $className;

    public $model;

    public $searchable = false;

    public $withActions = true;

    protected $actions = [];

    public $scopes = [];

    public $scope;

    public $filters = [];

    public $fields = [];

    public $pagination = true;

    public $per_page = 10;

    public $per_page_options = [5, 10, 20, 50];
    

    public function __construct()
    {
        $this->className = static::class;

        $this->setFields();

        $this->setScopes();

        $this->setActions();
    }

    abstract public function setFields();

    abstract public function setScopes();

    public function setScope($scope_name)
    {
        $this->scope = array_filter($this->scopes, function($scope) use ($scope_name) {
            return $scope->name == $scope_name;
        });
    }

    public function getFilters()
    {
        $filters = $this->searchable ? array_merge([QFilter::class], $this->filters) : $this->filters;
        if ($this->scope)
            $filters = array_merge($filters, $this->scope);
        return array_merge($filters, [
            DynamicFilter::class,
            RelationshipFilter::class
        ]);
    }

    abstract public function setActions();

    public function getActions()
    {
        return $this->actions;
    }

    public function getModelActions(Model $model)
    {
        $actions = [];
        foreach ($this->getActions() as $action) {
            if ($action_data = $action->resolveModelAction($model))
                $actions[$action->text] = $action_data;
        }
        return collect($actions);
    }
}