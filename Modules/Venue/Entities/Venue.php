<?php

namespace Modules\Venue\Entities;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    /**
     * @var string
     */
    protected $table = 'venues';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'capacity',
        'created_at',
        'updated_at',
    ];

}
