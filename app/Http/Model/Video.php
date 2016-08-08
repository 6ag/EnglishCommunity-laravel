<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Video
 * @package App\Http\Model
 * @property integer id
 * @property string title
 * @property integer video_info_id
 * @property string video_url
 * @property integer order
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 */
class Video extends Model
{
    protected $table = 'videos';
    protected $guarded = [];
}
