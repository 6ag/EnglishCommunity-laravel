<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MessageRecord
 * @package App\Http\Model
 * @property integer id
 * @property integer by_user_id
 * @property integer to_user_id
 * @property string type
 * @property integer source_id
 * @property string content
 * @property integer looked
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 */
class MessageRecord extends Model
{
    protected $table = 'message_records';
    protected $guarded = [];
}
