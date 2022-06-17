<?php

namespace App\Repositories;


use App\Models\Article;

class ArticleRepository
{
    protected $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function getAll()
    {
        return $this->article->all();
    }

    public function getById($id)
    {
        return $this->article->where('id', $id)->first();
    }

    public function create($data)
    {
        $article = new $this->article;
        $article->title = $data['title'];
        $article->description = $data['description'];
        $article->user_id = $data['user_id'];
        $article->active = $data['active'];
        $article->save();
        return $article->fresh();
    }

    public function update($data, $id)
    {
        $article = $this->article->find($id);

        $article->title = $data['title'];
        $article->description = $data['description'];
        $article->active = $data['active'];

        $article->update();
        return $article;
    }

    public function delete($id)
    {
        $article = $this->article->find($id);
        $article->delete();
        return $article;
    }
}
