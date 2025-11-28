<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // List tags + DataTables AJAX
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Tag::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function($row){
                    return '
                        <button class="btn btn-sm btn-primary editTagBtn" data-id="'.$row->id.'">Edit</button>
                        <button class="btn btn-sm btn-danger deleteTagBtn" data-id="'.$row->id.'">Delete</button>
                    ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('tags.index');
    }

    // Show single tag
    public function show(Tag $tag)
    {
        return response()->json(['success' => true, 'data' => $tag]);
    }

    // Edit tag (return JSON for modal)
    public function edit(Tag $tag)
    {
        return response()->json($tag);
    }

    // Store new tag
    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        Tag::create($request->only('name'));

        return response()->json(['success' => true, 'message' => 'Tag created successfully']);
    }

    // Update tag
    public function update(Request $request, Tag $tag)
    {
        $request->validate(['name' => 'required']);
        $tag->update($request->only('name'));

        return response()->json(['success' => true, 'message' => 'Tag updated successfully']);
    }

    // Delete tag
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return response()->json(['success' => true, 'message' => 'Tag deleted successfully']);
    }
}
