<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class GetCategoryController extends BaseController
{
    protected $model;
    public function __construct(Category $model){

        $this->model = $model;
    }
    public function __invoke(Request $request)
    {

      $categoory = $this->model->getCategory();

      return $this->sendResponse(CategoryResource::collection($categoory),'success');
    }
}
