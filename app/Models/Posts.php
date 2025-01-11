<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    /**Table Name**/
    protected $table = 'posts';
    /**Primary Key**/
    protected $primaryKey = 'post_id';
}
