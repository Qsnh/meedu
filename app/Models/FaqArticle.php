<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqArticle extends Model
{

    protected $table = 'faq_articles';

    protected $fillable = [
        'category_id', 'admin_id', 'title', 'content',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(FaqCategory::class, 'category_id');
    }

}
