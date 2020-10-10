<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model implements HasMedia
{
    use HasFactory;
    use Searchable;
    use InteractsWithMedia;

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag');
    }

    public function images()
    {
        return $this->hasMany('App\Models\GalleryImage');
    }
    
}
