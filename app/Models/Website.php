<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;

        protected $fillable = ['id','name', 'slug', 'url',
            'is_active','is_publish',
            'create_by', 'update_by'];

        public function keyword()
            {
               return $this->hasMany('App\Entities\Keyword','website_id');
            }
}
