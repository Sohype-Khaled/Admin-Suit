<?php


namespace Codtail\AdminSuit\Support\Contracts;

use Illuminate\Http\Request;

interface ApplyActionInterface
{
    public function validate();

    public function setRequest(Request $request);

    public function apply();

    public function call(Request $request);

    public function rules(): array;
}