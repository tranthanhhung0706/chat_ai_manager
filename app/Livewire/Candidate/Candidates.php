<?php

namespace App\Livewire\Candidate;

use Livewire\Component;
use App\Models\Candidate;
use Livewire\Attributes\On;
use Flux;
class Candidates extends Component
{

    public $candidates,$candidateId;

    public function mount()
    {
        $this->candidates=Candidate::all();
    }
    public function render()
    {
        return view('livewire.candidate.candidates');
    }
}
