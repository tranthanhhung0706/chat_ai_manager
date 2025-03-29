<?php

namespace App\Livewire\Candidate;

use Livewire\Component;
use Livewire\Attributes\On;
use Flux;
use App\Models\Candidate;
class CandidateDetails extends Component
{
    public $name,$age,$email,$phone,$gpa,$skill,$experience,$education;
    
    #[On("showCandidate")]
    public function showCandidate($id)
    {
        $candidate=Candidate::find($id);
        $this->name=$candidate->name;
        $this->age=$candidate->age;
        $this->email=$candidate->email;
        $this->phone=$candidate->phone;
        $this->gpa=$candidate->gpa;
        $this->skill = json_decode($candidate->skills, true) ?? [];
        $this->experience=json_decode($candidate->experience,true) ??[];
        $this->education=json_decode($candidate->education,true) ??[];
        //dd($this->experience);
        Flux::modal('details-candidate')->show();
    }
    public function render()
    {
        return view('livewire.candidate.candidate-details');
    }

    
}
