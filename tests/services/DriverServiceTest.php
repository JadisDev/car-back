<?php

namespace tests\services;

use App\Services\DriverService;
use Illuminate\Http\Request;
use TestCase;

class DriverServiceTest extends TestCase
{

    private $fakeService;
    private $fakeRequest;

    public function setUp(): void
    {
        $this->fakeService = $this->createMock(DriverService::class);
        $this->fakeRequest = $this->createMock(Request::class);
    }

    public function testSave()
    {
        $response = $this->getResponsePostDriver();
        $this->fakeService->method('save')->willReturn($response);
        $result = $this->fakeService->save($this->fakeRequest);
        $this->assertEquals($response, $result);
    }

    public function testAll()
    {
        $all = $this->getResponseAllDriver();
        $this->fakeService->method('all')->willReturn($all);
        $result = $this->fakeService->all();
        $this->assertEquals($all, $result);
        $this->assertEquals(count($all['data']), count($result['data']));
    }

    public function testSearchNameOrDocumentOrPlate() 
    {
        $param = 'teste';
        $filter = $this->getResponseAllDriver();
        $this->fakeService->method('searchNameOrDocumentOrPlate')->willReturn($filter);
        $result = $this->fakeService->searchNameOrDocumentOrPlate($param);
        $this->assertEquals($filter, $result);
        $this->assertTrue($result['status'] === 200);
    }

    public function testDelete()
    {
        $deleteId = 5;
        $delete = $this->getResponseDeleteDriver();
        $this->fakeService->method('delete')->willReturn($delete);
        $result = $this->fakeService->delete($deleteId);
        $this->assertEquals($delete, $result);
        $this->assertTrue($result['status'] === 200);
    }

    public function testUpdate() 
    {
        $updateId = 5;
        $update = $this->getResponseUpdateDriver();
        $this->fakeService->method('update')->willReturn($update);
        $result = $this->fakeService->update($updateId, $this->fakeRequest);
        $this->assertEquals($update, $result);
        $this->assertTrue($result['status'] === 200);
    }

    public function getResponseUpdateDriver(): array
    {
        $response = '{
            "data": {
                "name": "Teste",
                "document": "334455"
            },
            "status": 200
        }';
        return json_decode($response, true);
    }

    public function getResponseDeleteDriver(): array
    {
        $response = '{
            "data": {
                "id": 2,
                "name": "Adriano",
                "document": "23123122",
                "vehicle_id": 1,
                "created_at": null,
                "updated_at": null
            },
            "status": 200
        }';
        return json_decode($response, true);
    }

    public function getResponsePostDriver(): array
    {
        $response = '{
            "data": {
                "name": "Jadis",
                "document": "123",
                "vehicle_id": 2,
                "updated_at": "2023-05-23T22:20:42.000000Z",
                "created_at": "2023-05-23T22:20:42.000000Z",
                "id": 5
            },
            "status": 201
        }';
        return json_decode($response, true);
    }

    public function getResponseAllDriver() 
    {
        $response = '{
            "data": [
                {
                    "id": 3,
                    "name": "Lilian",
                    "document": "123123",
                    "vehicle_id": 1,
                    "created_at": null,
                    "updated_at": null,
                    "vehicle": {
                        "id": 1,
                        "plate": "123",
                        "model": "fiat - uno",
                        "created_at": null,
                        "updated_at": null
                    }
                }
            ],
            "status": 200
        }';
        return json_decode($response, true);
    }
}
