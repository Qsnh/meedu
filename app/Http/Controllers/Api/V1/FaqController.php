<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Api\V1;

use App\Models\FaqArticle;
use App\Models\FaqCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FaqArticleResource;
use App\Http\Resources\FaqCategoryResource;
use App\Http\Resources\FaqArticleDetailResource;
use App\Http\Resources\FaqArticleSingleResource;

class FaqController extends Controller
{
    /**
     * 分类列表.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function categories(Request $request)
    {
        $categories = FaqCategory::sortAsc()->paginate($request->input('page_size', 10));

        return FaqCategoryResource::collection($categories);
    }

    /**
     * 分类详情.
     *
     * @param $id
     *
     * @return FaqCategoryResource
     */
    public function category($id)
    {
        $category = FaqCategory::findOrFail($id);

        return new FaqCategoryResource($category);
    }

    /**
     * 文章列表.
     *
     * @param Request $request
     * @param $categoryId
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function articles(Request $request, $categoryId)
    {
        $category = FaqCategory::findOrFail($categoryId);
        $articles = $category->articles()->latest()->paginate($request->input('page_size', 10));

        return FaqArticleResource::collection($articles);
    }

    /**
     * 文章详情.
     *
     * @param $id
     *
     * @return FaqArticleDetailResource
     */
    public function article($id)
    {
        $article = FaqArticle::findOrFail($id);

        return new FaqArticleDetailResource($article);
    }

    /**
     * 最近文章.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function latestArticles(Request $request)
    {
        $articles = FaqArticle::with(['category'])->latest()->paginate($request->input('page_size', 10));

        return FaqArticleSingleResource::collection($articles);
    }
}
