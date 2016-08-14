<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tweets
 * @package App\Http\Model
 * @property integer id
 * @property integer user_id
 * @property string content
 * @property string photo
 * @property integer view
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 */
class Tweets extends Model
{
    protected $table = 'tweets';
    protected $guarded = [];
}
