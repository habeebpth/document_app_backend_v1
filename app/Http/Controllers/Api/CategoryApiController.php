<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryApiController extends Controller
{
    /**
     * Get all categories
     */

    public function index(Request $request)
    {
    $query = Category::select('id', 'name', 'status')
    ->orderBy('id', 'DESC'); // order by id descending

    // Pagination
    $limit = $request->input('limit', 10); // default 10 records per page
    $page  = $request->input('page', 1);   // default page 1

    $categories = $query->skip(($page - 1) * $limit)
    ->take($limit)
    ->get();

    return response()->json([
    'success' => true,
    'message' => 'Categories fetched successfully',
    'page' => $page,
    'limit' => $limit,
    'data' => $categories
    ], 200);

    
    }
}
