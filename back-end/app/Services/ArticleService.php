<?php

namespace App\Services;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Repositories\ArticleRepository;
use Exception;
use Illuminate\Support\Facades\Auth;

class ArticleService
{
    protected $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function getAllArticles()
    {
        return $this->articleRepository->getAll();
    }

    public function getArticleById($id){
        $article = $this->articleRepository->getById($id);
        if(!$article){
            throw new Exception('Article not found', 404);
        }
        return $article;
    }

    public function createArticle(StoreArticleRequest $request)
    {
        $data = $request->validated();
        $article = $this->articleRepository->create($data);
        return $article;
    }

    public function updateArticle(UpdateArticleRequest $request, $id)
    {
        $article = $this->articleRepository->getById($id);
        if(!$article){
            throw new Exception('Article not found', 404);
        }

        $data = $request->validated();
        $article = $this->articleRepository->update($data, $id);
        return $article;
    }

    public function deleteArticle($id)
    {

        $article = $this->articleRepository->getById($id);
        if(Auth::user()->id !== $article->user_id){
           throw new Exception('This action is unauthorized.', 401);
        }
        if(!$article){
            throw new Exception('Article not found', 404);
        }
        $article = $this->articleRepository->delete($id);
        return $article;
    }
}
