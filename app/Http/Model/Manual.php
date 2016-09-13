<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Manual
 * @package App\Http\Model
 * @property integer id
 * @property string title
 * @property string content
 * @property string mp3
 * @property integer gramar_categories_id
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 */
class Manual extends Model
{
    protected $table = 'manuals';
    protected $guarded = [];
}
