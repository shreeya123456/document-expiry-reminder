<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    // Get all documents of logged-in user
    public function index(Request $request)
    {
        return response()->json(
            $request->user()->documents()->latest()->get()
        );
    }

    // Add a document
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

        $document = $request->user()->documents()->create($validated);

        return response()->json([
            'message' => 'Document added successfully!',
            'document' => $document
        ], 201);
    }

    // Get one document
    public function show(Request $request, $id)
    {
        $document = $request->user()->documents()->findOrFail($id);

        return response()->json($document);
    }

    // Update a document
    public function update(Request $request, $id)
    {
        $document = $request->user()->documents()->findOrFail($id);

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

    // Delete a document
    public function destroy(Request $request, $id)
    {
        $document = $request->user()->documents()->findOrFail($id);

        $document->delete();

        return response()->json([
            'message' => 'Document deleted successfully!'
        ]);
    }

    // Get documents expiring within 30 days
    public function upcoming(Request $request)
    {
        $today = now()->toDateString();
        $next30Days = now()->addDays(30)->toDateString();

        $documents = $request->user()->documents()
            ->whereDate('expiry_date', '>=', $today)
            ->whereDate('expiry_date', '<=', $next30Days)
            ->get();

        $documents->each(function ($document) {
            $document->setAttribute(
                'expiry_status',
                $document->getExpiryStatus()
            );
        });

        return response()->json($documents);
    }

    // Get expired documents
    public function expired(Request $request)
    {
        $today = now()->toDateString();

        $documents = $request->user()->documents()
            ->whereDate('expiry_date', '<', $today)
            ->get();

        $documents->each(function ($document) {
            $document->setAttribute(
                'expiry_status',
                $document->getExpiryStatus()
            );
        });

        return response()->json($documents);
    }
    // Get dashboard statistics
public function statistics(Request $request)
{
    $documents = $request->user()->documents();

    $today = now()->toDateString();
    $next30Days = now()->addDays(30)->toDateString();

    $total = (clone $documents)->count();

    $expired = (clone $documents)
        ->whereDate('expiry_date', '<', $today)
        ->count();

    $expiringSoon = (clone $documents)
        ->whereDate('expiry_date', '>=', $today)
        ->whereDate('expiry_date', '<=', $next30Days)
        ->count();

    $active = (clone $documents)
        ->whereDate('expiry_date', '>', $next30Days)
        ->count();

    return response()->json([
        'total_documents' => $total,
        'active_documents' => $active,
        'expired_documents' => $expired,
        'expiring_soon' => $expiringSoon,
    ]);
}
}
