<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\StoreArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Http\Resources\Article\ArticleCollection;
use App\Models\Article;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Http;

class ArticleController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $source = 'Guardian News';
        $articles = [];
        try {
            switch ($source) {
//                case 'GUARDIAN_NEWS':
//                    $response = Http::acceptJson()
//                        ->get(env('THE_GARDIAN_API_BASE_URL', 'https://content.guardianapis.com/'));
//                    $response_to_json = json_decode($response->getBody()->getContents());
//                    break;
                case 'NEWS_ORG':
                    $url = env('NEWS_API_BASE_URL',
                            'https://newsapi.org/v2/everything') . '?apiKey=' . env('NEWS_API_KEY',
                            '69ff9976027b4541846d90cbfab76bbb');
                    $response = Http::acceptJson()
                        ->get($url);
                    $response_to_json = json_decode($response->getBody()->getContents());
                    break;
                case 'NEW_YORK_TIMES':
                    $url = env('NEW_YORK_TIMES_API_BASE_URL',
                            'https://api.nytimes.com/svc/search/v2/articlesearch.json') .
                        '?apiKey=' . env('NEW_YORK_TIMES_API_KEY', 'QShVXT2reFKLlUAgIb6hUKFZuBixg9hO');
                    $response = Http::acceptJson()
                        ->get($url);
                    $response_to_json = json_decode($response->getBody()->getContents());
                    break;
                default:
                    $url = env('THE_GARDIAN_API_BASE_URL', 'https://content.guardianapis.com/search?
                    q=&show-fields=headline,shortUrl,thumbnail,byline,trailText,body,productionOffice') .
                        '&api-key=' . env('THE_GARDIAN_API_KEY', 'af8a8525-f916-4807-8596-4843e179f452');
                    $response = Http::acceptJson()
                        ->get($url);
                    $response_to_json = json_decode($response->getBody()->getContents());
                    $articles_from_api = ((array)$response_to_json)["response"]->results;
                    foreach ($articles_from_api as $article) {
                        $new_article = [
                            "author" => $article->fields->byline,
                            "source" => $article->fields->productionOffice,
                            "title" => $article->webTitle,
                            "description" => $article->fields->trailText,
                            "content" => $article->fields->body,
                            "published_at" => $article->webPublicationDate,
                            "url_to_image" => $article->fields->thumbnail ?? null,
                            "url_to_article" => $article->fields->shortUrl,
                            "image_url" => $article->fields->thumbnail ?? null
                        ];
                        $articles[] = $new_article;
                    }
            }

            return new ArticleCollection($articles);
        } catch (Exception $e) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Third API Errors',
                'data' => $e->getMessage()
            ], 504));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        //
    }
}
