<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model {

    protected $fillable = [
        'plate', 'model',
    ];

    public function vehicle()
    {
        return $this->hasOne(Vehicle::class);
    }

}