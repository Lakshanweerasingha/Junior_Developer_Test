<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{

    protected $fillable = [
        'action', 
        'model', 
        'model_id', 
        'user_name',
        'action_time'
    ];
}
