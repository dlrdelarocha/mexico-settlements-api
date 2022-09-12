<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Settlement extends Model
{
    protected $collection = 'settlements';

    protected $hidden = [
        '_id'
    ];
}
