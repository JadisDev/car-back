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

    public function all()
    {
        return $this->service->all();
    }

    public function searchNameOrDocumentOrPlate(string $param)
    {
        return $this->service->searchNameOrDocumentOrPlate($param);
    }

    public function delete(int $id)
    {
        return $this->service->delete($id);
    }

    public function update(int $id, Request $request)
    {
        return $this->service->update($id, $request);
    }
}
