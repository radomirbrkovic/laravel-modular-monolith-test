<?php

namespace Modules\Venue\Entities;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $table = 'venues';
    protected $fillable = [
        'name',
        'capacity',
    ];

}
