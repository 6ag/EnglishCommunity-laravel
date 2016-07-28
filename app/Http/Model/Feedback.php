<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class App\Http\Model\Feedback
 * @property integer id
 * @property string contact
 * @property string content
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Feedback extends Model
{
    protected $table = 'feedback';
    protected $guarded = [];
}
