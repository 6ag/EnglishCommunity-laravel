<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class App\Http\Model\Category
 * @property integer id
 * @property string name
 * @property string alias
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Category extends Model
{
    protected $table = 'categories';
    protected $guarded = [];
}
