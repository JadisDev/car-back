<?php

namespace App\Http\Controllers;

use App\Services\DriverService;
use Illuminate\Http\Request;

class DriverController extends Controller
{

    private $service;

    public function __construct(DriverService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        return $this->service->save($request);
    }

    public function all(Request $request)
    {
        return $this->service->all($request);
    }
}
