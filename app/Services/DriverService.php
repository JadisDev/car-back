<?php

namespace App\Services;

use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DriverService extends Service
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function save(Request $request)
    {
        try {
            $validation = 'required|min:3';
            $this->validate($request, [
                'name' => $validation,
                'document' => $validation,
                'plate' => $validation,
                'model' => $validation,
            ]);
            DB::beginTransaction();

            $inputVehicle = $request->only('plate', 'model');
            $vehicle = Vehicle::create($inputVehicle);

            $inputDriver = $request->only('name', 'document');
            $inputDriver['vehicle_id'] = $vehicle->id;
            $driver = Driver::create($inputDriver);

            DB::commit();
            return $this->responseCreat($driver->toArray());
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->responseErro();
        }
    }

    public function all()
    {
        return $this->responseData(Driver::all()->toArray());
    }
}
