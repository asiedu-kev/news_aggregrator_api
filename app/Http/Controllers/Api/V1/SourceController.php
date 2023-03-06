<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Source\SourceCollection;
use App\Models\Source;

class SourceController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new SourceCollection(Source::paginate());
    }
}
