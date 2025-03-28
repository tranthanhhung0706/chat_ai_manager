<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\PdfToText\Pdf;
class PDFController extends Controller
{
    public function index()
    {
        return view('pdf');
    }
    public function store(Request $request)
    {
        $request->validate([
            'file'=>'required|mimes:pdf|max:2048'
        ]);
        $file=$request->file('file');
        $text= (new Pdf())
        ->setPdf($text)
        ->text();
        return back()->with(['text'=>$text]);
    }
}
