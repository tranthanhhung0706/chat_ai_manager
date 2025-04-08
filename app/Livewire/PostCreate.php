<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use Flux;
use Livewire\WithFileUploads;
use Spatie\PdfToText\Pdf;
class PostCreate extends Component
{
    use WithFileUploads;
    public $title,$body,$file_path;
    public function render()
    {
        return view('livewire.post-create');
    }
    public function submit()
    {
        $this->validate([
            'title'=>"required",
            'body'=>"required",
            'file_path' => 'required|mimes:pdf|max:2048',
        ]);

        $file=$this->file_path;
        $pdfToTextPath = 'C:\Users\ADMIN\Downloads\Compressed\Release-24.08.0-0\poppler-24.08.0\Library\bin\pdftotext.exe';
        
 
        $text = Pdf::getText($file->getPathname());
        
        $path = $this->file_path->store('files', 'public');
        Post::create([
            "title"=>$this->title,
            "body"=>$this->body,
            "file_path"=>$path
        ]);

        $this->resetForm();
        Flux::modal('create-post')->close();
        $this->dispatch("reloadPosts");
    }
    public function resetForm()
    {
        $this->title="";
        $this->body="";
    }
}
