<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ApiArticleController extends Controller
{
    public function getArticles(Request $request)
    {
        $articles = Article::where('id', '>', '0');

        if ($request->search) {
            $articles = $articles->where('title', 'LIKE', "%$request->search%");
        }

        $articles = $articles->orderBy('date', 'desc');

        $size = $request->size ?? 5;
        $page = $request->page ?? 1;
        $offset = $size * ($page - 1);

        $articlesCount = $articles->count();
        $articlesData = $articles->skip($offset)->take($size)->get();

        $lastPage = false;
        $pagesCount = $articlesCount / $size;
        $lastPageNumber = ceil($pagesCount);

        if ($page == $lastPageNumber || $articlesCount == 0) {
            $lastPage = true;
        }

        $maxWords = 25;
        $contentData = [];
        foreach ($articlesData as $articleData) {
            $articleData->content = str_replace('</p><p>', '. ', $articleData->content);
            $articleData->content = str_replace('<p>', '', $articleData->content);
            $articleData->content = str_replace('</p>', '', $articleData->content);

            $words = str_word_count($articleData->content, 2);

            if (count($words) > $maxWords) {
                $words = array_slice($words, 0, $maxWords);
                $articleData->content = implode(' ', $words) . '...';
            }

            array_push($contentData, [
                'id' => $articleData->id,
                'judul' => $articleData->title,
                'gambar' => $articleData->image,
                'deskripsi_pendek' => $articleData->content
            ]);
        }

        $data = [
            'page' => $page,
            'size' => $size,
            'last_page' => $lastPage,
            'content' => $contentData
        ];

        return response()->json([
            'code' => 200,
            'message' => "success",
            'data' => $data
        ]);
    }

    public function getArticleById($id)
    {
        $article = Article::find($id);

        $data = [];

        if ($article) {
            $data = [
                'id' => $article->id,
                'judul' => $article->title,
                'gambar' => [$article->image],
                'content' => $article->content,
                'tanggal' => $article->date,
            ];
        }

        return response()->json([
            'code' => 200,
            'message' => "success",
            'data' => $data
        ]);
    }
}
