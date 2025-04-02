<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
#use Spatie\PdfToText\Pdf;
use Spatie\PdfToImage\Pdf;

class PDFController extends Controller
{
    public function index()
    {
        return view('pdf');
    }
    public function store(Request $request)
    {
        $request->validate([
            'file'=>'required|mimes:pdf|max:10240'
        ]);
        $file=$request->file('file');
        // $text= (new Pdf())
        // ->setPdf($file)
        // ->text();
        $pdfUrl = "https://arxiv.org/pdf/2408.09869"; // URL của file PDF
    $pdfPath = storage_path('app/public/input.pdf'); // Lưu vào storage

    // Tải file PDF từ URL
    $response = Http::get($pdfUrl);
    file_put_contents($pdfPath, $response->body());

    // Chuyển PDF thành ảnh
    $imagePath = storage_path('app/public/output.jpg');
    $pdf = new Pdf($pdfPath);
    $pdf->saveImage($imagePath);
    return response()->json([
        'message' => 'PDF converted to image successfully!',
        'image_url' => asset('storage/output.jpg')
    ]);

        // dd($text);
        // return back()->with(['text'=>$text]);
    }
}
