<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    // Table name
    protected $table = 'messages';

    // Primary key
    public $primaryKey = 'id';

    // Timestamps
    public $timestamps = true;

    public function user() {
        return $this->belongsTo('App\User');
    }

    public static function valueOf($column, $id) {
        $message = Message::find($id);
        return $message->select($column)->get()[0][$column];
    }

}
