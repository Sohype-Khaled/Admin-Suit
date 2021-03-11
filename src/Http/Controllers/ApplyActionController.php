<?php

namespace Codtail\AdminSuit\Http\Controllers;

use Illuminate\Http\Request;

class ApplyActionController extends Controller
{
    public function __invoke(Request $request)
    {
        $action = $request->input('action');
        return (new $action())->call($request);
    }
}
