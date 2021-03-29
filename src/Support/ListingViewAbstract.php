<?php


namespace Codtail\AdminSuit\Support;


use Codtail\AdminSuit\Support\Displays\TableDisplay;
use Codtail\AdminSuit\Support\Filters\DynamicFilter;
use Codtail\AdminSuit\Support\Filters\QFilter;
use Codtail\AdminSuit\Support\Filters\RelationshipFilter;
use Codtail\AdminSuit\Support\Scopes\DefaultScope;
use Illuminate\Database\Eloquent\Model;

abstract class ListingViewAbstract
{
    public $className;

    protected $model;

    public $searchable = false;

    public $withActions = true;

    public $scopes = [];

    public $scope;

    public $filters = [];

    public $fields = [];

    public $displays = [];

    public $display;

    public $default_display = 'TableDisplay';

    public $visible_fields = [];
    public $per_page = 10;
    public $per_page_options = [5, 10, 20, 50];
    protected $actions = [];

    public function __construct()
    {
        $this->className = static::class;

        $this->fields = $this->getFields();

        $this->scopes = $this->getScopes();

        $this->displays = $this->getDisplays();

        $this->actions = $this->getActions();

//        if (is_null($this->display))
//            $this->setDisplay($this->default_display);
    }

    public function getFields()
    {
        return array_map(function ($field) {
            return [
                'component' => (new \ReflectionClass($field))->getShortName(),
                'attrs' => $this->getFieldAttrs(clone $field),
                'operators' => $field->operators
            ];
        }, $this->setFields());
    }

    abstract public function setFields();

    public function getFieldAttrs($field)
    {
        unset($field->operators);
        return $field;
    }

    public function getScopes()
    {
        return  array_merge([
            new DefaultScope()
        ], $this->setScopes());
        return $this->setScopes();
    }

    abstract public function setScopes();

    public function getDisplays()
    {
        return array_map(function ($display) {
            return [
                'component' => (new \ReflectionClass($display))->getShortName(),
                'attrs' => $display,
            ];
        }, array_merge([
            new TableDisplay
        ], $this->setDisplays()));
    }

    abstract public function setDisplays();

    public function getActions()
    {
        return $this->setActions();
    }

    abstract public function setActions();

    public function setScope($scope_name)
    {
        $this->scope = array_filter($this->scopes, function ($scope) use ($scope_name) {
            return $scope->name == $scope_name;
        });
    }

    public function getDisplay()
    {
        return $this->display;
    }

    public function setDisplay($display_name)
    {
        $this->display =  $this->displays[array_search($display_name, array_column($this->displays, 'component'))];
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

    public function getModelActions(Model $model)
    {
        $actions = [];
        foreach ($this->getActions() as $action) {
            if ($action_data = $action->resolveModelAction($model))
                $actions[$action->text] = $action_data;
        }
        return collect($actions);
    }

    public function getModel()
    {
        return $this->model;
    }
}