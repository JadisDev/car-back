<?php

use App\Services\DriverService;
use Illuminate\Http\Request;

class DriverServiceTest extends TestCase
{

    private $fakeService;

    public function setUp(): void
    {
        $this->fakeService = $this->createMock(DriverService::class);
    }

    public function testSave()
    {
        $response = $this->getResponsePostDriver();
        $fakeRequest = $this->createMock(Request::class);
        $this->fakeService->method('save')->willReturn($response);
        $result = $this->fakeService->save($fakeRequest);
        $this->assertEquals($response, $result);
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
}
