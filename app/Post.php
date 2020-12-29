<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Notifiable;

    protected $fillable = [
        'id',
        'title', 
        'description',
        'status',
        'create_user_id',
        'updated_user_id',
        'deleted_user_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    
}
