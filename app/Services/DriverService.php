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
        $this->validation($request);
        try {
            DB::beginTransaction();

            $inputVehicle = $request->only('plate', 'model');
            $vehicle = Vehicle::where('plate', $inputVehicle['plate'])->first();
            if (!$vehicle) {
                $vehicle = Vehicle::create($inputVehicle);
            }

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
        return $this->responseData(Driver::with('vehicle')->get()->toArray());
    }

    public function searchNameOrDocumentOrPlate(string $param)
    {
        $result = DB::table('drivers')
            ->select('*')
            ->join('vehicles', 'drivers.vehicle_id', '=', 'vehicles.id')
            ->where('drivers.name', 'like', '%' . $param . '%')
            ->orWhere('drivers.document', 'like', '%' . $param . '%')
            ->orWhere('vehicles.plate', 'like', '%' . $param . '%')
            ->get();
        return $this->responseData($result->toArray());
    }

    public function delete(int $id)
    {
        $driver = Driver::find($id);
        if (!$driver) {
            return $this->responseNotFoundData(['motorista não encontrado']);
        }
        $driver->delete();
        return $this->responseData($driver->toArray());
    }

    public function update(int $id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'document' => 'min:3',
        ]);
        $inputDataUpdate = $request->all();
        $driver = Driver::find($id);
        if (!$driver) {
            return $this->responseNotFoundData(['motorista não encontrado']);
        }
        $driver->update($request->all());
        return $this->responseData($request->all());
    }

    private function validation(Request $request)
    {
        $validation = 'required|min:3';
        $this->validate($request, [
            'name' => $validation,
            'document' => $validation,
        ]);
    }
}
