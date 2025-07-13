<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    public $timestamps = false; // karena kita pakai 'timestamp' manual
    protected $fillable = ['user', 'activity', 'description', 'timestamp'];
}
