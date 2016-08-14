<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment
 * @package App\Http\Model
 * @property integer id
 * @property string type
 * @property integer source_id
 * @property integer user_id
 * @property string content
 * @property integer pid
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 */
class Comment extends Model
{
    protected $table = 'comments';
    protected $guarded = [];
}