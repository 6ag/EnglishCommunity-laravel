<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class App\Http\Model\User
 * @property integer id
 * @property string nickname
 * @property string say
 * @property string avatar
 * @property string mobile
 * @property integer sex
 * @property integer status
 * @property integer is_admin
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class User extends Model
{
    protected $table = 'users';
    protected $guarded = ['is_admin'];
}
