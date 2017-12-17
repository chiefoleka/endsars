<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionIncidents extends Model
{
    public $table = 'incident_action';

    public $guarded = [];

    public $timestamps = false;

}
