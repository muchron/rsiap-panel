<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleLabels extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleLabelsFactory> */
    use HasFactory;


    function label()
    {
        return $this->belongsTo(Labels::class);
    }
}
