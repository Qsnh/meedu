<?php

namespace Tests\Feature\Api\V1;

use App\Http\Resources\FaqArticleResource;
use App\Http\Resources\FaqCategoryResource;
use App\Models\FaqArticle;
use App\Models\FaqCategory;
use Tests\OriginalTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FaqTest extends OriginalTestCase
{

    public function test_faq_categories()
    {
        $categories = factory(FaqCategory::class, 8)->create();
        $response = $this->json('GET', '/api/v1/faq/categories');
        foreach ($categories as $category) {
            $response->assertJsonFragment((new FaqCategoryResource($category))->toArray(request()));
        }
    }

    public function test_faq_category_detail()
    {
        $category = factory(FaqCategory::class)->create();
        $this->json('GET', '/api/v1/faq/category/'.$category->id)
            ->assertJsonFragment((new FaqCategoryResource($category))->toArray(request()));
    }

    public function test_articles()
    {
        $category = factory(FaqCategory::class)->create();
        $articles = factory(FaqArticle::class, 8)->create([
            'category_id' => $category->id,
        ]);
        $response = $this->json('GET', '/api/v1/faq/category/'.$category->id.'/articles');
        foreach ($articles as $index => $article) {
            $response->assertJsonFragment((new FaqArticleResource($article))->toArray(request()));
        }
    }

    public function test_latest_articles()
    {
        $articles = factory(FaqArticle::class, 8)->create();
        $response = $this->json('GET', '/api/v1/faq/article/latest');
        foreach ($articles as $article) {
            $response->assertJsonFragment((new FaqArticleResource($article))->toArray(request()));
        }
    }

}
