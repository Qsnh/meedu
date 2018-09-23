<?php

namespace App\Http\Controllers\Frontend;

use App\Models\FaqArticle;
use App\Models\FaqCategory;
use App\Http\Controllers\Controller;

class FaqController extends Controller
{

    public function index()
    {
        $categories = FaqCategory::all();
        return view('frontend.faq.index', compact('categories'));
    }

    public function showCategoryPage($categoryId)
    {
        $category = FaqCategory::findOrFail($categoryId);
        $categories = FaqCategory::all();
        $articles = $category->articles()->orderByDesc('updated_at')->paginate(15);
        return view('frontend.faq.category_detail', compact('category', 'categories', 'articles'));
    }

    public function showArticlePage($articleId)
    {
        $article = FaqArticle::findOrFail($articleId);
        $categories = FaqCategory::all();
        return view('frontend.faq.article_detail', compact('article', 'categories'));
    }

}
