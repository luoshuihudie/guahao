<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class TaskModel extends Model
{
    protected $table = 'guahao';
    public $timestamps = true;
    protected $fillable = ['username'];
}
