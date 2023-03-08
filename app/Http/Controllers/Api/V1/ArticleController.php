<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Article\StoreArticleRequest;
use App\Http\Resources\Article\ArticleCollection;
use App\Http\Resources\Article\ArticleResource;
use App\Models\Article;
use App\Models\Preference;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ArticleController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $source = $request->source;
        $keyword = $request->keyword;
        $from = $request->from;
        $to = $request->to;
        $articles = [];
        try {
            switch ($source) {
                case 'GUARDIAN_NEWS':
                    $url = env('THE_GARDIAN_API_BASE_URL', 'https://content.guardianapis.com/search') .
                        '?api-key=' . env('THE_GARDIAN_API_KEY', 'af8a8525-f916-4807-8596-4843e179f452') .
                        '&q=' . $keyword . '&show-fields=headline,shortUrl,
                        thumbnail,byline,trailText,body,productionOffice&from-date=' . $from . '&to-date=' . $to;
                    $response = Http::acceptJson()
                        ->get($url);
                    $response_to_json = json_decode($response->getBody()->getContents());
                    $articles_from_api = ((array)$response_to_json)["response"]->results;
                    foreach ($articles_from_api as $article) {
                        $new_article = [
                            "author" => $article->fields->byline ?? 'Guardian News',
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
                    break;
                case 'NEW_YORK_TIMES':
                    $url = env('NEW_YORK_TIMES_API_BASE_URL',
                            'https://api.nytimes.com/svc/search/v2/articlesearch.json') .
                        '?q=' . $keyword . '&api-key=' . env('NEW_YORK_TIMES_API_KEY',
                            'QShVXT2reFKLlUAgIb6hUKFZuBixg9hO') . '&pub_date=' . $from;
                    $response = Http::acceptJson()
                        ->get($url);
                    $response_to_json = json_decode($response->getBody()->getContents());
                    $articles_from_api = $response_to_json->response->docs;
                    foreach ($articles_from_api as $article) {
                        $new_article = [
                            "author" => $article->byline->original,
                            "source" => $article->source ?? "The New York Times",
                            "title" => $article->headline->main,
                            "description" => $article->abstract,
                            "content" => $article->lead_paragraph,
                            "published_at" => $article->pub_date,
                            "url_to_image" => count($article->multimedia) == 0 ? null :
                                'https://www.nytimes.com/' . $article->multimedia[0]->url,
                            "url_to_article" => $article->web_url,
                            "image_url" => count($article->multimedia) == 0 ? null :
                                'https://www.nytimes.com/' . $article->multimedia[0]->url
                        ];
                        $articles[] = $new_article;
                    }
                    break;
                default:
                    $url = env('NEWS_API_BASE_URL',
                            'https://newsapi.org/v2/everything?sources=bbc-news') . '&q=' . $keyword . '&apiKey=' .
                        env('NEWS_API_KEY',
                            '69ff9976027b4541846d90cbfab76bbb') . '&from=' . $from . '&to=' . $to;
                    $response = Http::acceptJson()
                        ->get($url);
                    $response_to_json = json_decode($response->getBody()->getContents());
                    $articles_from_api = $response_to_json->articles;
                    foreach ($articles_from_api as $article) {
                        $new_article = [
                            "author" => $article->author,
                            "source" => $article->source->name,
                            "title" => $article->title,
                            "description" => $article->description,
                            "content" => $article->content,
                            "published_at" => $article->publishedAt,
                            "url_to_image" => $article->urlToImage,
                            "url_to_article" => $article->url,
                            "image_url" => $article->urlToImage
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

    public function store(StoreArticleRequest $request)
    {
        $article = Article::create($request->all());
        $account = auth()->user()->account;
        $preference = Preference::where(['account_id' => $account->id])->first();
        if (!$preference) {
            $preference = Preference::create([
                'account_id' => $account->id,
                'article_ids' => json_encode([$article->id])
            ]);
            $account->update(['preference_id' => $preference->id]);
        } else {
            $article_ids = json_decode($preference->article_ids);
            $article_ids[] = $article->id;
            $preference->update(['article_ids' => json_encode($article_ids)]);
        }
        return new ArticleResource($article);
    }
}
