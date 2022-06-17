<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Services\ArticleService;
use Exception;

class ArticleController extends Controller
{

    protected $articleService;


    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = [
            'status' => 200,
            'data' => $this->articleService->getAllArticles()
        ];
        return response($result, $result['status']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArticleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleRequest $request)
    {
        $result['status'] = 200;
        try {
            $result['data'] = $this->articleService->createArticle($request);
        }catch(Exception $e){
            $result = [
                'status' => $e->getCode(),
                'error' => $e->getMessage()
            ];
        }

        return response($result, $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $result['status'] = 200;
        try{
            $result['data'] = $this->articleService->getArticleById($article->id);
        }catch(Exception $e){
            $result = [
                'status' => $e->getCode(),
                'error' => $e->getMessage()
            ];
        }
        return response($result, $result['status']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateArticleRequest  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $result['status'] = 200;

        try{
            $result['data'] = $this->articleService->updateArticle($request, $article->id);
        }catch(Exception $e){
            $result = [
                'status' => 400,
                'error' => $e->getCode()
            ];
        }
        return response($result, $result['status']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $result = [
            'status' => 200,
            'data' => $this->articleService->deleteArticle($article->id)
        ];

        return response($result, $result['status']);
    }
}
