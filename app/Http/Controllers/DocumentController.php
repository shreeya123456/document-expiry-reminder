<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index()
    {
        return response()->json(Document::latest()->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'document_name' => 'required|string|max:255',
            'document_type' => 'required|string|max:255',
            'document_number' => 'nullable|string|max:255',
            'issue_date' => 'nullable|date',
            'expiry_date' => 'required|date',
            'reminder_days' => 'nullable|integer|min:1',
        ]);

        $document = Document::create($validated);

        return response()->json([
            'message' => 'Document added successfully!',
            'document' => $document
        ], 201);
    }

    public function show($id)
    {
        return response()->json(Document::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $document = Document::findOrFail($id);

        $validated = $request->validate([
            'document_name' => 'sometimes|required|string|max:255',
            'document_type' => 'sometimes|required|string|max:255',
            'document_number' => 'nullable|string|max:255',
            'issue_date' => 'nullable|date',
            'expiry_date' => 'sometimes|required|date',
            'reminder_days' => 'nullable|integer|min:1',
        ]);

        $document->update($validated);

        return response()->json([
            'message' => 'Document updated successfully!',
            'document' => $document
        ]);
    }

    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        $document->delete();

        return response()->json([
            'message' => 'Document deleted successfully!'
        ]);
    }
}