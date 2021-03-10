<?php


namespace Codtail\AdminSuit\Support\Actions;

use Codtail\AdminSuit\Support\ActionAbstract;
use Illuminate\Database\Eloquent\Model;

class LinkAction extends ActionAbstract
{

    public $route;

    public $authorization_callback;

    public function route($route_name)
    {
        $this->route = [
            'name' => $route_name,
            'params' => []
        ];
        return $this;
    }

    public function parameter($key, $value, $skip_replace = false)
    {
        $this->route['params'][] = ['param' => [$key => $value], 'skip_replace' => $skip_replace];
        return $this;
    }

    public function resolveModelAction($model)
    {
        if ($this->authorization_callback && !call_user_func($this->authorization_callback, $model))
            return false;

        return [
            'type' => 'link',
            'route' => $this->resolveRoute($model),
            'text' => $this->text,

        ];
    }


    public function resolveRoute($model)
    {
        $params = [];
        foreach ($this->route['params'] as $param) {
            foreach ($param['param'] as $key => $value) {
                if ($param['skip_replace']) {
                    $params[$key] = $value;
                } else {
                    $params[$key] = $model->$value;
                }
            }
        }
        return route($this->route['name'], $params);
    }


    public static function getRoute(Model $model, $route)
    {
        $params = [];
        foreach ($route['params'] as $param) {
            foreach ($param['param'] as $key => $value) {
                if ($param['skip_replace']) {
                    $params[$key] = $value;
                } else {
                    $params[$key] = $model->$value;
                }
            }
        }
        return route($route['name'], $params);
    }

    public function authorize(\Closure $callback)
    {
        $this->authorization_callback = $callback;
        return $this;
    }
}
