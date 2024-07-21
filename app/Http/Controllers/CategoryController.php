<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaboratoryService;


class CategoryController extends Controller
{
    public function getServices($categoryId)
    {
        $services = LaboratoryService::where('category_id', $categoryId)->get();
        return response()->json(['data' => $services]);
    }
    
}
