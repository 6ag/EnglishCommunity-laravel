<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FavoriteRecord
 * @package App\Http\Model
 * @property integer id
 * @property string type
 * @property integer source_id
 * @property integer user_id
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 */
class FavoriteRecord extends Model
{
    protected $table = 'favrite_records';
    protected $guarded = [];
}
