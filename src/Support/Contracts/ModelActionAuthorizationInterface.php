<?php


namespace Codtail\AdminSuit\Support\Contracts;


interface ModelActionAuthorizationInterface
{
    public function setAuthorization();

    public function authorize($model): bool;

    public function showIf(\Closure $callback);

    public function checkCanShow($model): bool;

    public function resolveModelAction($model);
}
