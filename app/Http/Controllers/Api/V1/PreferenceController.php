<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;
use App\Http\Resources\Article\ArticleCollection;
use App\Models\Article;
use App\Models\Preference;

class PreferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $account = auth()->user()->account;
        $preference = Preference::where(['account_id' => $account->id])->first();
        if ($preference) {
            $article_ids = json_decode($preference->article_ids);
            $articles = [];
            foreach ($article_ids as $id) {
                $article = Article::find($id);
                if ($article) {
                    $articles[] = $article;
                }
            }
            return new ArticleCollection($articles);
        } else {
            return new ArticleCollection([]);
        }

    }
}
