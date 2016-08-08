<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App\Http\Model
 * @property integer id
 * @property string nickname
 * @property string say
 * @property string avatar
 * @property string mobile
 * @property string email
 * @property integer sex
 * @property integer status
 * @property integer is_admin
 * @property integer qq_binding
 * @property integer weixin_binding
 * @property integer email_binding
 * @property integer mobile_binding
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 */
class User extends Model
{
    protected $table = 'users';
    protected $guarded = ['is_admin'];
}
