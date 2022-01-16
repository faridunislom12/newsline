<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'category_id',
        'text',
        'images',
        'publish_at',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'images' => 'array',
    ];

    /**
     * Get the article category.
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    protected $appends = ['image'];

    public function getImageAttribute()
    {
        return $this->images[0] ?? (object)[];
    }


}
