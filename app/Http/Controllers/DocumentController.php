<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // LIST DOCUMENTS + DataTables AJAX
   public function index(Request $request)
{
    if ($request->ajax()) {
        $data = Document::latest()->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('category', fn($row) => $row->category->name ?? '-')
            ->addColumn('tags', fn($row) => $row->tags->pluck('name')->join(', '))
            ->addColumn('action', function($row){
                return '
                    <button class="btn btn-sm btn-primary editDocBtn" data-id="'.$row->id.'">Edit</button>
                    <button class="btn btn-sm btn-danger deleteDocBtn" data-id="'.$row->id.'">Delete</button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    $categories = Category::all(); // Pass categories
    $tags = Tag::all();            // Pass tags
    return view('documents.index', compact('categories', 'tags'));
}


    // Show single document
    public function show(Document $document)
    {
        return response()->json(['success' => true, 'data' => $document]);
    }

    // Edit document (return JSON for modal)
    public function edit(Document $document)
    {
        $categories = Category::all();
        $tags = Tag::all();
        $selectedTags = $document->tags->pluck('id')->toArray();

        return response()->json([
            'document' => $document,
            'categories' => $categories,
            'tags' => $tags,
            'selectedTags' => $selectedTags
        ]);
    }

    // Store new document
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'category_id' => 'required',
            'subject' => 'required',
            'title' => 'required',
        ]);

        $data = $request->except('tags');

        if ($request->hasFile('file_1')) {
            $data['file_1'] = $request->file('file_1')->store('documents', 'public');
        }
        if ($request->hasFile('file_2')) {
            $data['file_2'] = $request->file('file_2')->store('documents', 'public');
        }

        $document = Document::create($data);
        $tagIds = json_decode($request->tags, true) ?? [];
        $document->tags()->sync($tagIds);

        return response()->json(['success' => true, 'message' => 'Document saved successfully']);
    }

    // Update document
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'date' => 'required',
            'category_id' => 'required',
            'subject' => 'required',
            'title' => 'required',
        ]);

        $data = $request->except('tags');

        if ($request->hasFile('file_1')) {
            $data['file_1'] = $request->file('file_1')->store('documents', 'public');
        }
        if ($request->hasFile('file_2')) {
            $data['file_2'] = $request->file('file_2')->store('documents', 'public');
        }

        $document->update($data);

        $tagIds = json_decode($request->tags, true) ?? [];
        $document->tags()->sync($tagIds);

        return response()->json(['success' => true, 'message' => 'Document updated successfully']);
    }

    public function destroy(Document $document)
    {
    $document->update([
    'status' => 'inactive'
    ]);

    $document->delete();
    return response()->json([
    'success' => true,
    'message' => 'Document deleted successfully'
    ]);
    }

}
