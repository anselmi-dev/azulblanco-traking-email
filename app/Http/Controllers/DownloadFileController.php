<?php

namespace App\Http\Controllers;

use App\Models\ExcelFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadFileController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, ExcelFile $file_excel)
    {
        return Storage::download($file_excel->file);
    }
}
