<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Driver;
use App\Models\Vehicle;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Collection as CollectionSupport;

class DriverService extends Service
{
    public function save(Request $request): Driver
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
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function all(): Collection
    {
        return Driver::with('vehicle')->get();
    }

    public function searchNameOrDocumentOrPlate(string $param): CollectionSupport
    {
        return Driver::select('drivers.*')
            ->join('vehicles', 'drivers.vehicle_id', '=', 'vehicles.id')
            ->where('drivers.name', 'like', '%' . $param . '%')
            ->orWhere('drivers.document', 'like', '%' . $param . '%')
            ->orWhere('vehicles.plate', 'like', '%' . $param . '%')
            ->with('vehicle')
            ->get();
    }

    public function delete(int $id): Driver
    {
        $driver = Driver::find($id);
        if (!$driver) {
            throw new NotFoundException("Motorista não encontrado");
        }
        $driver->delete();
        return $driver;
    }

    public function update(int $id, Request $request): Driver
    {
        $this->validate($request, [
            'name' => 'min:3',
            'document' => 'min:3',
        ]);
        $driver = Driver::find($id);
        if (!$driver) {
            throw new NotFoundException("Motorista não encontrado");
        }
        $driver->name = $request->get('name') ? $request->get('name') : $driver->name;
        $driver->document = $request->get('document') ? $request->get('document') : $driver->document;
        $driver->save();
        return $driver;
    }

    private function validation(Request $request)
    {
        $validation = 'required|min:3';
        $this->validate($request, [
            'name' => $validation,
            'document' => $validation,
            'plate' => $validation,
            'model' => $validation
        ]);
    }
}
