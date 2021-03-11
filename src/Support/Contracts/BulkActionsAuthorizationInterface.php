<?php


namespace Codtail\AdminSuit\Support\Contracts;


interface BulkActionsAuthorizationInterface
{
    public function setBulkAuthorization();

    public function bulkAuthorize(): bool;

    public function resolveBulkActions($model);
}