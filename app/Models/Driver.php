<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model {

    protected $fillable = [
        'name', 'document', 'vehicle_id',
    ];

    public function vehicle()
    {
        return $this->hasOne(Vehicle::class);
    }

}