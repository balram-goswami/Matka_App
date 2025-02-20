<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    /**Table Name**/
	protected $table = 'options';
    
    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
   protected $fillable = [
       'optionName',
       'optionValue'
   ];
}
