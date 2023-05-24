<?php

use App\Services\DriverService;
use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
    * @covers App\Services\Service::response
    * @covers App\Services\Service::responseCreat
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
        $response = $service->save($request);
        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    /**
    * @covers App\Services\DriverService::all
    * @covers App\Models\Driver::vehicle
    * @covers App\Services\Service::response
    * @covers App\Services\Service::responseData
    */
    public function testAll()
    {
        $this->creatData();

        $service = new DriverService();
        $response = $service->all();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $result = json_decode($response->content());
        $this->assertTrue(count($result->data) >= 1);
    }

    /**
    * @covers App\Services\DriverService::searchNameOrDocumentOrPlate
    * @covers App\Models\Driver::vehicle
    * @covers App\Services\Service::response
    * @covers App\Services\Service::responseData
    */
    public function testSearchNameOrDocumentOrPlate()
    {
        $this->creatData();
        $service = new DriverService();
        $response = $service->searchNameOrDocumentOrPlate('John Doe');
        $this->assertInstanceOf(JsonResponse::class, $response);
        $result = json_decode($response->content());
        $this->assertTrue(count($result->data) >= 1);
    }

    /**
    * @covers App\Services\DriverService::delete
    * @covers App\Services\DriverService::searchNameOrDocumentOrPlate
    * @covers App\Models\Driver::vehicle
    * @covers App\Services\Service::response
    * @covers App\Services\Service::responseData
    */
    public function testDelete()
    {
        $driver = $this->creatData();
        $service = new DriverService();
        $response = $service->delete($driver->id);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $search = $service->searchNameOrDocumentOrPlate('John Doe');
        $result = json_decode($search->content());
        $this->assertIsArray($result->data);
        $this->assertTrue(count($result->data) === 0);
    }

    /**
    * @covers App\Services\DriverService::update
    * @covers App\Models\Driver::vehicle
    * @covers App\Services\Service::response
    * @covers App\Services\Service::responseData
    */
    public function testUpdate()
    {
        $driver = $this->creatData();
        $request = new Request([
            'name' => 'Updated Name',
            'document' => '987654321',
        ]);

        $service = new DriverService();
        $response = $service->update($driver->id, $request);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $result = json_decode($response->content());
        $this->assertEquals($result->data->name, 'Updated Name');
        $this->assertEquals($result->data->document, '987654321');
    }
}
