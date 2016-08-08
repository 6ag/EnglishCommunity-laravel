<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class VideoInfo
 * @package App\Http\Model
 * @property integer id
 * @property string title
 * @property string intro
 * @property string photo
 * @property integer view
 * @property integer category_id
 * @property string teacher
 * @property string type
 * @property integer recommend
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 */
class VideoInfo extends Model
{
    protected $table = 'video_infos';
    protected $guarded = [];
}
