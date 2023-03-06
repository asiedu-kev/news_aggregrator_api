<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Category\CategoryCollection;
use App\Models\Category;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new CategoryCollection(Category::paginate());
    }
    
}
