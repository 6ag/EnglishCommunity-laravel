<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tweets
 * @package App\Http\Model
 * @property integer id
 * @property integer user_id
 * @property integer app_client
 * @property string content
 * @property string photos
 * @property string photo_thumbs
 * @property string at_user_ids
 * @property string at_nicknames
 * @property integer view
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 */
class Tweets extends Model
{
    protected $table = 'tweets';
    protected $guarded = [];
}
