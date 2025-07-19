<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Articles extends Model
{
    /** @use HasFactory<\Database\Factories\ArticlesFactory> */
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

    public function labels()
    {
        return $this->belongsToMany(Labels::class, 'article_labels', 'articles_id', 'label_id');
    }

    public function scopeMonth($builder, $month)
    {
        return $builder->whereMonth('created_at', $month);
    }
    public function scopeIsPublished($builder)
    {
        return $builder->where('status', 'published');
    }
}
