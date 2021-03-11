<?php

namespace Codtail\AdminSuit\Support;

use Codtail\AdminSuit\Support\ActionAbstract;
use Codtail\AdminSuit\Support\Contracts\ApplyActionInterface;
use Codtail\AdminSuit\Support\Contracts\BulkActionsAuthorizationInterface;
use Codtail\AdminSuit\Support\Contracts\ModelActionAuthorizationInterface;
use Illuminate\Database\Eloquent\Model;
use Codtail\AdminSuit\Support\Traits\ApplyAction;


abstract class DefaultActionAbstract extends ActionAbstract implements ModelActionAuthorizationInterface,
ApplyActionInterface, BulkActionsAuthorizationInterface
{

    use ApplyAction;

    public $danger = false;

    public $renderIf;

    public $authorization_callback;

    public $bulk_authorization_callback;

    public $message_title = 'You are about to preform this action';

    public $message_body = 'Are you sure?';

    public function __construct()
    {
        $this->setAuthorization();

        $this->setBulkAuthorization();
    }

    abstract public function rules(): array;

    abstract public function setAuthorization();

    abstract public function setBulkAuthorization();

    abstract public function apply();

    public function resolveModelAction($model)
    {
        if (!$this->authorize($model) || !$this->checkCanShow($model)) return false;

        return [
            'danger' => $this->danger,
            'text' => $this->text,
            'message_title' => $this->message_title,
            'message_body' => $this->message_body,
            'action_model' => get_class($model),
            'action_class' => get_class($this),
            'action_items' => $model->id,
            'type' => 'action'
        ];
    }

    public function resolveBulkActions($model)
    {
        if (!$this->bulkAuthorize()) return false;

        return [
            'danger' => $this->danger,
            'text' => $this->text,
            'message_title' => $this->message_title,
            'message_body' => $this->message_body,
            'action_model' => $model,
            'action_class' => get_class($this),
            'type' => 'action'
        ];
    }

    // public static function renderBulk($action, $model): string
    // {
    //     if (self::bulkAuthorize($action)) return "";
    //     return "<button
    //         disabled
    //         type=button
    //         title='{$action['text']}'
    //         class='{$action['style_classes']} btn-bulk-action'
    //         data-title='{$action['message_title']}'
    //         data-message='{$action['message_body']}'
    //         data-model='{$model}'
    //         data-action='{$action['class_name']}'
    //         data-toggle='modal'
    //         data-target='#action-modal'>
    //         <i class='{$action['icon']}'></i>
    //     </button>";
    // }


    public function authorize($model): bool
    {
        return $this->authorization_callback && call_user_func($this->authorization_callback, $model);
    }

    public  function bulkAuthorize(): bool
    {
        return $this->bulk_authorization_callback && call_user_func($this->bulk_authorization_callback);
    }

    public function showIf(\Closure $callback)
    {
        $this->renderIf = $callback;
        return $this;
    }

    public function checkCanShow($model): bool
    {
        return $this->renderIf && call_user_func($this->renderIf, $model);
    }
}
