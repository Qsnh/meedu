<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{

    protected $table = 'faq_categories';

    protected $fillable = [
        'name', 'sort',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(FaqArticle::class, 'category_id');
    }

    /**
     * 作用域：排序
     * @param $query
     * @return mixed
     */
    public function scopeSortAsc($query)
    {
        return $query->orderBy('sort');
    }

}
