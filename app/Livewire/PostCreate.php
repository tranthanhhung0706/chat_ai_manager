<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use Flux;
use Livewire\WithFileUploads;
use Spatie\PdfToText\Pdf;
use OpenAI;
use App\Models\Candidate;
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
        $schema = [
            "type" => "object",
            "properties" => [
                "name" => ["type" => "string", "description" => "Full name of the candidate."],
                "email" => ["type" => "string", "description" => "Email address of the candidate."],
                "phone" => ["type" => "string", "description" => "Phone number of the candidate."],
                "address" => ["type" => "string", "description" => "Full residential address of the candidate."],
                "education" => [
                    "type" => "array",
                    "items" => [
                        "type" => "object",
                        "properties" => [
                            "degree" => ["type" => "string", "description" => "Degree or certification obtained."],
                            "institution" => ["type" => "string", "description" => "Name of the educational institution."],
                            "gpa" => ["type" => "number", "description" => "GPA of the candidate (if applicable)."]
                        ],
                        "required" => ["degree", "institution"]
                    ],
                    "description" => "List of educational qualifications or degrees."
                ],
                "age" => ["type" => "integer", "description" => "Age of the candidate."],
                "gpa" => ["type" => "number", "description" => "GPA of the candidate (if applicable)."],
                "skills" => [
                    "type" => "array",
                    "items" => ["type" => "string"],
                    "description" => "List of skills the candidate possesses."
                ],
                "experience" => [
                    "type" => "array",
                    "items" => [
                        "type" => "object",
                        "properties" => [
                            "company" => ["type" => "string", "description" => "Company where the candidate worked."],
                            "role" => ["type" => "string", "description" => "Job position or role held by the candidate."],
                            "years" => ["type" => "string", "description" => "Duration of employment in years."]
                        ],
                        "required" => ["company", "role", "years"]
                    ],
                    "description" => "List of previous work experiences."
                ]
            ],
            "required" => ["name", "email", "phone"]
        ];
        $client = OpenAI::client(env('OPENAI_API_KEY'));
        $this->validate([
            'title'=>"required",
            'body'=>"required",
            'file_path' => 'required|mimes:pdf|max:2048',
        ]);

        $file=$this->file_path;
        $pdfToTextPath = 'C:\Users\ADMIN\Downloads\Compressed\Release-24.08.0-0\poppler-24.08.0\Library\bin\pdftotext.exe';
        
        $text = Pdf::getText($file->getPathname());
        $response = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ["role" => "system", "content" => "Extract the following contact and professional information as JSON following the given schema: " . json_encode($schema)],
            ["role" => "user", "content" => "Convert this text into JSON format:\n\n" . $text]
            ],
            'response_format' => ['type' => 'json_object'],
          ]);
        $jsonOutput = $response['choices'][0]['message']['content'];

        $datacandicate = json_decode($jsonOutput, true);
        Candidate::create([
            'name' => $datacandicate['name'] ?? null,
            'email' => $datacandicate['email'] ?? null,
            'phone' => $datacandicate['phone'] ?? null,
            'age'=>$datacandicate['age'] ?? null,
            'gpa' => $datacandicate['gpa'] ?? null,
            'skills' => json_encode($datacandicate['skills'] ?? []),
            'experience' => json_encode($datacandicate['experience'] ?? []),
            'education' => json_encode($datacandicate['education'] ?? []),
            'cv_file' => $this->file_path->store('files','s3'),
        ]);
        $path = $this->file_path->store('files', 'public');
        #$path = $this->file_path->store('files', 's3');
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
