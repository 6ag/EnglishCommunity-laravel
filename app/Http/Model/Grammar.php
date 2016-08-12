<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Grammar
 * @package App\Http\Model
 * @property integer id
 * @property string title
 * @property string content
 * @property integer gramar_categories_id
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 */
class Grammar extends Model
{
    protected $table = 'grammars';
    protected $guarded = [];
}
