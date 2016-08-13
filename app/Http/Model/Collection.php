<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Collection
 * @package App\Http\Model
 * @property integer id
 * @property integer user_id
 * @property integer video_info_id
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 */
class Collection extends Model
{
    protected $table = 'collections';
    protected $guarded = [];
}
