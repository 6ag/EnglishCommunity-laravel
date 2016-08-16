<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Friend
 * @package App\Http\Model
 * @property integer user_id
 * @property integer relation
 * @property integer relation_user_id
 * @property  \Carbon\Carbon created_at
 * @property  \Carbon\Carbon updated_at
 */
class Friend extends Model
{
    protected $table = 'friends';
    protected $guarded = [];
}
