<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // List categories + DataTables AJAX
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '
                        <button class="btn btn-sm btn-primary editBtn" data-id="'.$row->id.'">Edit</button>
                        <button class="btn btn-sm btn-danger deleteBtn" data-id="'.$row->id.'">Delete</button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('categories.index');
    }

    // Show single category
    public function show(Category $category)
    {
        return response()->json(['success'=>true,'data'=>$category]);
    }

    // Edit category
    public function edit(Category $category)
    {
        return response()->json($category);
    }

    // Store new category
    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->validated());
        return response()->json(['success'=>true,'message'=>'Category created successfully']);
    }

    // Update category
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return response()->json(['success'=>true,'message'=>'Category updated successfully']);
    }

    // Delete category
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['success'=>true,'message'=>'Category deleted successfully']);
    }
}
