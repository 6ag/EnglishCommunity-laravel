<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class App\Http\Model\User
 * @property integer id
 * @property string username
 * @property string password
 * @property string nickname
 * @property string say
 * @property string avatar
 * @property string mobile
 * @property integer score
 * @property integer sex
 * @property integer qq_binding
 * @property integer wx_binding
 * @property integer wb_binding
 * @property integer group_id
 * @property integer permission_id
 * @property integer status
 * @property string token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class User extends Model
{
    protected $table = 'users';
    protected $guarded = [];
}
