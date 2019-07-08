<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    // Table name
    protected $table = 'cars';

    // Primary key
    public $primaryKey = 'id';

    // Timestamps
    public $timestamps = false;

    public function user() {
        return $this->belongsTo('App\User');
    }

    public static function valueOf($column, $id) {
        $car = Car::find($id);
        return $car->select($column)->get()[0][$column];
    }

    public static function name($id) {
        return Car::valueOf('brand', $id).' '.Car::valueOf('model', $id).', '.Car::valueOf('color', $id);
    }

}
