<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Route extends Model
{
    // Table name
    protected $table = 'routes';

    // Primary key
    public $primaryKey = 'id';

    // Timestamps
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function valueOf($column, $id)
    {
        return Route::find($id)->toArray()[$column];
    }

    public function stops($id)
    {
        $str = $this->valueOf('stops', $id);
        return explode(',', $str);
    }

    public function departure($id)
    {
        return $this->stops($id)[0];
    }

    public function arrival($id)
    {
        return $this->stops($id)[count($this->stops($id)) - 1];
    }

    public function type($id)
    {
        return $this->valueOf('type', $id);
    }

    public function steps($id)
    {
        $steps = [];
        $stops = $this->stops($id);
        foreach ($stops as $stop) {
            if ($stop != $this->departure($id) && $stop != $this->arrival($id) && $stop != $stops[count($stops) - 1])
                $steps[] = $stop;
        }
        return $steps;
    }

    public function days($id)
    {
        if ($this->type($id) == "0") {
            $days = $this->valueOf('days', $id);
            $days = explode(',', $days);

            $array = [];
            foreach ($days as $day_value) {
                $expl = explode('=', $day_value);
                $day = $expl[0];
                $value = $expl[1];
                $array[$day] = $value;
            }

            return $array;
        } else {
            return Route::date_us_to_fr($this->valueOf('date', $id));
        }
    }

    public function hours($id)
    {
        if ($this->type($id) == "0") {
            $hours = $this->valueOf('hours', $id);
            $hours = explode(',', $hours);

            $array = [];
            foreach ($hours as $day_hour) {
                $expl = explode('=', $day_hour);
                $day = $expl[0];
                $hour = $expl[1];
                $array[$day] = $hour;
            }

            return $array;
        } else {
            return Route::shorten_hour($this->valueOf('day_hour', $id));
        }
    }

    public function numberplate($id)
    {
        $car_id = $this->valueOf('car_id', $id);
        $numberplate = Car::find($car_id)->numberplate;
        return $numberplate;
    }



    //--------//
    public static function date_fr_to_us($date_fr) {
        $expl = explode('/', $date_fr);
        return $expl[1].'-'.$expl[0].'-'.$expl[2];
    }

    public static function date_us_to_fr($date_us) {
        $expl = explode('-', $date_us);
        return $expl[2].'/'.$expl[1].'/'.$expl[0];
    }

    public static function searchdate_us_to_fr($searchdate_us)
    {
        $expl = explode('-', $searchdate_us);
        return $expl[1] . '/' . $expl[0] . '/' . $expl[2];
    }

    public static function shorten_hour($hour) {
        $expl = explode(':', $hour);
        return $expl[0].':'.$expl[1];
    }

}
