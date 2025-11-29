<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;


class DocumentApiController extends Controller
{
   
   public function index(Request $request)
{
    $query = Document::query();

    // Filter by exact date
    if (!empty($request->date)) {
        $query->whereDate('date', $request->date);
    }

    // Filter by subject
    if (!empty($request->subject)) {
        $query->where('subject', 'LIKE', "%{$request->subject}%");
    }

     if (!empty($request->category_id)) {
        $query->where('category_id', $request->category_id);
    }

    // Search filter (title, subject, date)
    if (!empty($request->search)) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('title', 'LIKE', "%{$search}%")
              ->orWhere('subject', 'LIKE', "%{$search}%")
              ->orWhere('date', 'LIKE', "%{$search}%");
        });
    }

    // Filter by year
    if (!empty($request->year)) {
        $query->whereYear('date', $request->year);
    }

    // Filter by month
    if (!empty($request->month)) {
        $query->whereMonth('date', $request->month);
    }

 

    // $documents = $query->orderBy('id', 'DESC')->get()->map(function ($doc) {
    //     return [
    //         'id' => $doc->id,
    //         'date' => $doc->date ? \Carbon\Carbon::parse($doc->date)->format('Y-m-d') : null,
    //         'category_id' => $doc->category_id,
    //         'subject' => $doc->subject,
    //         'title' => $doc->title,
    //         'description' => strip_tags($doc->description),
    //         'content' => strip_tags($doc->content),
    //         'file_1' => $doc->file_1 
    //             ? asset('storage/documents/' . basename($doc->file_1)) 
    //             : null,
    //         'file_2' => $doc->file_2 
    //             ? asset('storage/documents/' . basename($doc->file_2)) 
    //             : null,
    //         'created_at' => $doc->created_at 
    //             ? $doc->created_at->format('Y-m-d H:i:s') 
    //             : null,
    //         'updated_at' => $doc->updated_at 
    //             ? $doc->updated_at->format('Y-m-d H:i:s') 
    //             : null,
    //         'status' => $doc->status
    //     ];
    // });

    // return response()->json([
    //     'status' => true,
    //     'documents' => $documents
    // ]);


    $limit = $request->input('limit', 10);  // number of records per request
    $page  = $request->input('page', 1);   // current page, default 1

    $documents = $query->orderBy('id', 'DESC')
    ->skip(($page - 1) * $limit) // skip previous records
    ->take($limit)               // take only $limit records
    ->get()
    ->map(function ($doc) {
    return [
    'id' => $doc->id,
    'date' => $doc->date ? \Carbon\Carbon::parse($doc->date)->format('Y-m-d') : null,
    'category_id' => $doc->category_id,
    'subject' => $doc->subject,
    'title' => $doc->title,
    'description' => strip_tags($doc->description),
    'content' => strip_tags($doc->content),
    'file_1' => $doc->file_1 ? asset('storage/documents/' . basename($doc->file_1)) : null,
    'file_2' => $doc->file_2 ? asset('storage/documents/' . basename($doc->file_2)) : null,
    'created_at' => $doc->created_at ? $doc->created_at->format('Y-m-d H:i:s') : null,
    'updated_at' => $doc->updated_at ? $doc->updated_at->format('Y-m-d H:i:s') : null,
    'status' => $doc->status,
    ];
    });

    return response()->json([
    'status' => true,
    'page' => $page,
    'limit' => $limit,
    'documents' => $documents
    ]);

}

    public function show($id)
    {
        $doc = Document::find($id);

        if (!$doc) {
            return response()->json([
                'status' => false,
                'message' => 'Document not found'
            ], 404);
        }

        $document = [
            'id' => $doc->id,
            'date' => $doc->date ? Carbon::parse($doc->date)->format('Y-m-d') : null,
            'category_id' => $doc->category_id,
            'subject' => $doc->subject,
            'title' => $doc->title,
            'description' => strip_tags($doc->description),
            'content' => strip_tags($doc->content),
            'file_1' => $doc->file_1 ? asset('storage/documents/' . basename($doc->file_1)) : null,
            'file_2' => $doc->file_2 ? asset('storage/documents/' . basename($doc->file_2)) : null,
            'created_at' => $doc->created_at ? $doc->created_at->format('Y-m-d H:i:s') : null,
            'updated_at' => $doc->updated_at ? $doc->updated_at->format('Y-m-d H:i:s') : null,
            'status' => $doc->status
        ];

        return response()->json([
            'status' => true,
            'document' => $document
        ]);
    }





public function searchAll(Request $request)
{
    if (!$request->filled('search')) {
        return response()->json([
            'status' => false,
            'message' => 'Search text required'
        ]);
    }

    $search = $request->search;

    // Get all columns (optional, just for dynamic search)
    $columns = Schema::getColumnListing('documents');

    $query = Document::query();

    // Apply search on all columns
    $query->where(function ($q) use ($columns, $search) {
        foreach ($columns as $column) {
            $q->orWhere($column, 'LIKE', "%{$search}%");
        }
    });

    $results = $query->orderBy('id', 'DESC')->get()->map(function ($doc) {
        return [
            'id' => $doc->id,
            'date' => $doc->date ? Carbon::parse($doc->date)->format('Y-m-d') : null,
            'category_id' => $doc->category_id,
            'subject' => $doc->subject,
            'title' => $doc->title,
            'description' => strip_tags($doc->description),
            'content' => strip_tags($doc->content),
            'file_1' => $doc->file_1 
                ? asset('storage/documents/' . basename($doc->file_1)) 
                : null,
            'file_2' => $doc->file_2 
                ? asset('storage/documents/' . basename($doc->file_2)) 
                : null,
            'status' => $doc->status,
            'created_at' => $doc->created_at ? $doc->created_at->format('Y-m-d H:i:s') : null,
            'updated_at' => $doc->updated_at ? $doc->updated_at->format('Y-m-d H:i:s') : null,
        ];
    });

    return response()->json([
        'status' => true,
        'data' => $results
    ]);
}


}
