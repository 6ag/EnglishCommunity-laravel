<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class App\Http\Model\Group
 * @property integer id
 * @property string name
 * @property string sign
 */
class Group extends Model
{
    protected $table = 'groups';
    protected $guarded = [];
}
