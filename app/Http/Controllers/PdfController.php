<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Prospecting;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function downloadpdf()
    {
        $user = Auth::user();

        $prospectings = Prospecting::where('createdBy', $user->name)->get();

        $data = [
            'user' => $user,
            'prospectings' => $prospectings,
        ];

        $pdf = Pdf::loadView('pdf', $data);

        return $pdf->download('prospecting-file.pdf');
    }
}
