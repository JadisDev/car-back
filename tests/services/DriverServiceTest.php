<?php

use App\Exceptions\NotFoundException;
use App\Services\DriverService;
use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as CollectionSupport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Testing\DatabaseTransactions;

class DriverServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function creatData(): Driver
    {
        $vehicle = Vehicle::create([
            'plate' => 'ABC123',
            'model' => 'Car Model',
        ]);

        return Driver::create([
            'name' => 'John Doe',
            'document' => '123456789',
            'vehicle_id' => $vehicle->id
        ]);
    }

    /**
    * @covers App\Services\DriverService::save
    * @covers App\Services\DriverService::validation
    */
    public function testSave()
    {
        $request = new Request([
            'name' => 'John Doe',
            'document' => '123456789',
            'plate' => 'ABC123',
            'model' => 'Car Model',
        ]);

        $service = new DriverService();
        $drive = $service->save($request);
        $this->assertInstanceOf(Driver::class, $drive);
    }

    /**
    * @covers App\Services\DriverService::all
    * @covers App\Models\Driver::vehicle
    */
    public function testAll()
    {
        $this->creatData();
        $service = new DriverService();
        $response = $service->all();
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertTrue(count($response->toArray()) >= 1);
    }

    /**
    * @covers App\Services\DriverService::searchNameOrDocumentOrPlate
    * @covers App\Models\Driver::vehicle
    */
    public function testSearchNameOrDocumentOrPlate()
    {
        $this->creatData();
        $service = new DriverService();
        $response = $service->searchNameOrDocumentOrPlate('John Doe');
        $this->assertInstanceOf(CollectionSupport::class, $response);
        $this->assertTrue(count($response->toArray()) >= 1);
    }

    /**
    * @covers App\Services\DriverService::delete
    * @covers App\Services\DriverService::searchNameOrDocumentOrPlate
    * @covers App\Models\Driver::vehicle
    */
    public function testDelete()
    {
        $driver = $this->creatData();
        $service = new DriverService();
        $driver = $service->delete($driver->id);
        $this->assertInstanceOf(Driver::class, $driver);
        $search = $service->searchNameOrDocumentOrPlate('John Doe');
        $this->assertInstanceOf(CollectionSupport::class, $search);
        $this->assertTrue(count($search->toArray()) === 0);
    }

    /**
    * @covers App\Services\DriverService::delete
    * @covers App\Services\DriverService::searchNameOrDocumentOrPlate
    * @covers App\Models\Driver::vehicle
    * @covers App\Exceptions\NotFoundException::__construct
    */
    public function testDeleteFail()
    {
        $service = new DriverService();
        $this->expectException(NotFoundException::class);
        $service->delete(9999);
    }

    /**
    * @covers App\Services\DriverService::update
    * @covers App\Models\Driver::vehicle
    */
    public function testUpdate()
    {
        $driver = $this->creatData();
        $request = new Request([
            'name' => 'Updated Name',
            'document' => '987654321',
        ]);

        $service = new DriverService();
        $driver = $service->update($driver->id, $request);
        $this->assertInstanceOf(Driver::class, $driver);
        $this->assertEquals($driver->toArray()['name'], 'Updated Name');
        $this->assertEquals($driver->toArray()['document'], '987654321');
    }

    /**
    * @covers App\Services\DriverService::update
    * @covers App\Services\DriverService::searchNameOrDocumentOrPlate
    * @covers App\Models\Driver::vehicle
    * @covers App\Exceptions\NotFoundException::__construct
    */
    public function testUpdateFail()
    {
        $request = new Request([
            'name' => 'Updated Name',
            'document' => '987654321',
        ]);
        $service = new DriverService();
        $this->expectException(NotFoundException::class);
        $service->update(9999, $request);
    }
}
