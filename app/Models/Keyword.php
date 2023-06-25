<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    use HasFactory;

    protected $fillable = ['id','name', 'slug',
        'google_rank','google_searches','yahoo_rank','yahoo_searches','website_id',
                'is_active','is_publish',
                'create_by', 'update_by'];

    public function website()
            {
                return $this->belongsTo('App\Models\Website', 'website_id');
            }
}
