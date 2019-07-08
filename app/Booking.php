<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    // Table name
    protected $table = 'bookings';

    // Primary key
    public $primaryKey = 'id';

    // Timestamps
    public $timestamps = false;

    public function user() {
        return $this->belongsTo('App\User');
    }

    public static function valueOf($column, $id) {
        $booking = Booking::find($id);
        return $booking->select($column)->get()[0][$column];
    }

}
