<?php


namespace Codtail\AdminSuit\Support;


abstract class DisplayAbstract
{
    public $withPagination = false;

    public $items = [];

    public $meta = [];

    public $per_page = 10;

    protected $builder;

    public function response()
    {
        return $this->withPagination
            ? ['meta' => $this->meta, 'items' => $this->items]
            : ['items' => $this->items];
    }

    public function resolve($builder)
    {
        $this->builder = $builder;

        $this->per_page = request()->has('per_page') ? request()->input('per_page') : 10;

        $this->builder = $this->resolveQuery();
        if ($this->withPagination) {
            $this->items = $this->builder->items();

            $this->meta = $this->setMeta($this->builder->toArray());
        } else

            $this->items = $this->builder;

        return $this;
    }

    abstract public function resolveQuery();

    public function setMeta($paginator)
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