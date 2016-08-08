<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserAuth
 * @package App\Http\Model
 * @property integer id
 * @property integer user_id
 * @property string identity_type
 * @property string identifier
 * @property string credential
 * @property integer verified
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 */
class UserAuth extends Model
{
    protected $table = 'user_auths';
    protected $guarded = [];
}