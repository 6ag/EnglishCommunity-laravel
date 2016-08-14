<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LikeRecord
 * @package App\Http\Model
 * @property integer id
 * @property string type
 * @property integer source_id
 * @property integer user_id
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 */
class LikeRecord extends Model
{
    protected $table = 'like_records';
    protected $guarded = [];
}