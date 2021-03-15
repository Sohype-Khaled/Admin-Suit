<?php


namespace Codtail\AdminSuit\Support\Filters;

use Codtail\AdminSuit\Support\FilterAbstract;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Str;

class DynamicFilter extends FilterAbstract
{

    public $payload = [];

    public $pipeline = [];

    protected function apply($builder)
    {
        $this->prepare();

        return app(Pipeline::class)
            ->send($builder)
            ->through($this->pipeline)
            ->thenReturn();
    }

    public function prepare()
    {
        foreach (request('dynamic') as $filter) {
            $params = explode('-', $filter);

            if (!$params[1]) continue;

            $operator = [];

            if (request()->has($params[1]))
                $operator = request($params[1]);

            $operator[] = [
                'field' => $params[0], 'arguments' => $params[2]
            ];

            request()->request->add([$params[1] => $operator]);

            $this->pipeline[] = $this->getOperator($params[1]);
        }
    }

    public function getOperator($name)
    {
        return "Codtail\\AdminSuit\\Support\\Operators\\" . Str::camel($name) . "Operator";
    }
}