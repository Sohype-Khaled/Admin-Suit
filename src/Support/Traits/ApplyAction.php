<?php

namespace Codtail\AdminSuit\Support\Traits;

use Illuminate\Http\Request;

trait ApplyAction
{
    public $request;

    public $model;

    public $target;

    public $toQueue = false;

    public function call(Request $request)
    {
        $this->setRequest($request);

        $this->validate();

        $this->setModel();

        $this->setTarget();

        $this->toQueue ? dispatch(function () {
            $this->apply();
        }) : $this->apply();

        return $this->response();
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    public function validate()
    {
        $this->request->validate(array_merge($this->rules(), [

        ]));
    }

    public function setModel()
    {
        $this->model = $this->request->input('action_model');
    }

    public function setTarget()
    {
        $this->target = explode(',', $this->request->input('action_items'));
    }

    abstract public function apply();

    abstract public function response();
}