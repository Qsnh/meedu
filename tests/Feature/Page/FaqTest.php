<?php

namespace Tests\Feature\Page;

use App\Models\FaqArticle;
use App\Models\FaqCategory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FaqTest extends TestCase
{

    public function test_visit_faq()
    {
        $this->visit(route('faq'))
            ->see('帮助中心');
    }

    public function test_see_some_category()
    {
        $category = factory(FaqCategory::class)->create();
        $this->visit(route('faq'))
            ->see($category->name);
    }

    public function test_see_some_article()
    {
        $articles = factory(FaqArticle::class, 5)->create();
        $response = $this->visit(route('faq'));
        foreach ($articles as $article) {
            $response->see($article->title);
        }
    }

    public function test_see_faq_article()
    {
        $article = factory(FaqArticle::class)->create();
        $this->visit(route('faq.article.show', $article))
            ->see($article->title)
            ->see($article->admin->name);
    }

}
