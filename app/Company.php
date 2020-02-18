<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';
    public $timestamps = false;

    /**
     * Get city.
     */
    public function city()
    {
        return $this->hasOne('App\City', 'id', 'city_id');
    }

    /**
     * Get dates.
     */
    public function dates()
    {
        return $this->hasMany('App\Dates', 'company_id', 'id');
    }
}
