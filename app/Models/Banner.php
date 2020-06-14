<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = ['order', 'title', 'desc', 'url', 'image', 'is_hidden', 'type'];

}
