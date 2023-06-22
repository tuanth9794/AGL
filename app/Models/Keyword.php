<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    use HasFactory;

    protected $fillable = ['id','name', 'slug', 'rank','searches','website_id',
                'is_active','is_publish',
                'create_by', 'update_by'];

    public function website()
            {
                return $this->belongsTo('App\Entities\Website', 'website_id');
            }
}
