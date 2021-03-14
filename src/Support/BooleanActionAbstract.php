<?php


namespace Codtail\AdminSuit\Support;


abstract class BooleanActionAbstract extends DefaultActionAbstract
{
    public $state_callback;

    public $truth;

    public $falseness;


    public function __construct()
    {
        parent::__construct();

        $this->setStateCallback();
    }

    abstract public function setStateCallback();

    public function resolveModelAction($model)
    {
        if (!$this->authorize($model) || !$this->checkCanShow($model)) return false;

        $state = call_user_func($this->state_callback, $model);

        return [
            'danger' => $this->danger,
            'text' => !$state ? $this->truth : $this->falseness,
            'message_title' => $this->message_title,
            'message_body' => $this->message_body,
            'action_model' => get_class($model),
            'action_class' => get_class($this),
            'action_items' => $model->id,
            'action_value' => !$state,
            'type' => 'action'
        ];
    }

    public function resolveBulkActions($model)
    {
        if (!$this->bulkAuthorize()) return false;

        return [
            [
                'danger' => $this->danger,
                'text' => $this->falseness,
                'message_title' => $this->message_title,
                'message_body' => $this->message_body,
                'action_model' => $model,
                'action_class' => get_class($this),
                'action_value' => 0
            ],
            [
                'danger' => $this->danger,
                'text' => $this->truth,
                'message_title' => $this->message_title,
                'message_body' => $this->message_body,
                'action_model' => $model,
                'action_class' => get_class($this),
                'action_value' => 1
            ]
        ];
    }

    abstract public function response();

    abstract public function rules(): array;

    abstract public function setAuthorization();

    abstract public function setBulkAuthorization();

    abstract public function apply();
}