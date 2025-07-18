<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleLabels extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleLabelsFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'articles_id',
        'label_id',
    ];


    function label()
    {
        return $this->belongsTo(Labels::class);
    }
}
