<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    // Download PDF report
    public function pdf(Request $request)
    {
        $documents = $request->user()
            ->documents()
            ->latest()
            ->get();

        $pdf = Pdf::loadView('reports.documents-pdf', [
            'documents' => $documents
        ]);

        return $pdf->download('document-report.pdf');
    }
}