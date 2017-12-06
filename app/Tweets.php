<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tweets extends Model
{
    public $table = 'tweets';

    public $guarded = [];
}
