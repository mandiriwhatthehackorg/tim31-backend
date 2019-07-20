<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ["user_id", "name", "target_amount", "target_date"];
}
