<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Terms extends Model
{
	/**Table Name**/
	protected $table = 'terms';
	protected $fillable = ['name', 'slug', 'term_group'];
}
