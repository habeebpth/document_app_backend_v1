<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;

class DocumentApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::query();


        if (!empty($request->date)) {
        $query->whereDate('date', $request->date);
        }


        if (!empty($request->subject)) {
        $query->where('subject', 'LIKE', "%{$request->subject}%");
        }

        if (!empty($request->search)) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
        $q->where('title', 'LIKE', "%{$search}%")
        ->orWhere('subject', 'LIKE', "%{$search}%")
        ->orWhere('date', 'LIKE', "%{$search}%");
        });
        }


        $documents = $query->orderBy('id', 'DESC')->get()->map(function ($doc) {

        return [
        'id' => $doc->id,
        'date' => $doc->date ? \Carbon\Carbon::parse($doc->date)->format('Y-m-d') : null,
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
        'created_at' => $doc->created_at 
        ? $doc->created_at->format('Y-m-d H:i:s') 
        : null,

        'updated_at' => $doc->updated_at 
        ? $doc->updated_at->format('Y-m-d H:i:s') 
        : null,

        'status' => $doc->status
        ];
        });

        return response()->json([
            'status' => true,
            'documents' => $documents
        ]);
    }
}
