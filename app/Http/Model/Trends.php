<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Trends
 * @package App\Http\Model
 * @property integer id
 * @property integer user_id
 * @property string content
 * @property string photo
 * @property integer view
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 */
class Trends extends Model
{
    protected $table = 'trends';
    protected $guarded = [];
}
