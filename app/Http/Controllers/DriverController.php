<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Services\DriverService;
use App\Utils\ResponseApi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class DriverController extends Controller
{

    private $service;

    public function __construct(DriverService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        try {
            /** @var Illuminate\Database\Eloquent\Collection $driver */
            $driver = $this->service->save($request);
            return ResponseApi::success($driver->toArray());
        } catch(ValidationException $e) {
            return ResponseApi::warning($e->getMessage(), $e->errors());
        } catch(Exception $e) {
            return ResponseApi::error($e);
        }
    }

    public function all()
    {
        try {
            $drivers = $this->service->all();
            return ResponseApi::success($drivers->toArray());
        } catch(ValidationException $e) {
            return ResponseApi::warning($e->getMessage(), $e->errors());
        } catch(Exception $e) {
            return ResponseApi::error($e);
        }
    }

    public function searchNameOrDocumentOrPlate(string $param)
    {
        try {
            $data = $this->service->searchNameOrDocumentOrPlate($param);
            return ResponseApi::success($data->toArray());
        } catch(ValidationException $e) {
            return ResponseApi::warning($e->getMessage(), $e->errors());
        } catch(Exception $e) {
            return ResponseApi::error($e);
        }
    }

    public function delete(int $id)
    {
        try {
            $driver = $this->service->delete($id);
            return ResponseApi::success($driver->toArray());
        } catch(NotFoundException $e) {
            return ResponseApi::warning($e->getMessage(), [], Response::HTTP_NOT_FOUND);
        } catch(Exception $e) {
            return ResponseApi::error($e);
        }
    }

    public function update(int $id, Request $request)
    {
        return $this->service->update($id, $request);
    }
}
