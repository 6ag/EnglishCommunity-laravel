<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class App\Http\Model\Permission
 * @property integer id
 * @property string name
 * @property string sign
 */
class Permission extends Model
{
    protected $table = 'permissions';
    protected $guarded = [];
}
