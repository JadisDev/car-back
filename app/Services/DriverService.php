<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Collection as CollectionSupport; 

class DriverService extends Service
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function save(Request $request) : Driver
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
            return $driver;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function all() : Collection
    {
        return Driver::with('vehicle')->get();
    }

    public function searchNameOrDocumentOrPlate(string $param) : CollectionSupport
    {
        return DB::table('drivers')
            ->select('*')
            ->join('vehicles', 'drivers.vehicle_id', '=', 'vehicles.id')
            ->where('drivers.name', 'like', '%' . $param . '%')
            ->orWhere('drivers.document', 'like', '%' . $param . '%')
            ->orWhere('vehicles.plate', 'like', '%' . $param . '%')
            ->get();
    }

    public function delete(int $id)
    {
        $driver = Driver::find($id);
        if (!$driver) {
            throw new NotFoundException("Motorista não encontrado");
        }
        $driver->delete();
        return $driver;
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
