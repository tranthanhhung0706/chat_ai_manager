<div>
    {{-- The Master doesn't talk, he acts. --}}
    
    <flux:modal name="details-candidate" class="md:w-156">
        
     <div class="space-y-6">
        <div class="max-w-8xl mx-auto p-6 bg-white rounded-lg shadow-lg">
            
            <!-- Personal Information -->
            <div class="mb-4">
                <h3 class="text-xl font-semibold">Personal Information</h3>
                <p><strong>Name:</strong> {{ $name }}</p>
                <p><strong>Age:</strong> {{ $age }}</p>
                <p><strong>Phone:</strong> {{ $phone }}</p>
                <p><strong>Email:</strong> {{ $email }}</p>
                <p><strong>Gpa:</strong> {{ $gpa }}</p>
            </div>
        
            <!-- Skills -->


            <div class="mb-4">
            
            <p><strong>Skills</strong> </p>
            @if(is_array($this->skill) && count($this->skill) > 0)
                <ul class="list-disc pl-6">
                @foreach($this->skill as $skill)
                <li>{{ $skill }}</li>
                @endforeach
                </ul>
            @else
                <p>No skills available</p>
            @endif

            </div>

            <div class="mb-4">
                <p > <strong>Work Experience</strong></p>
                @if(is_array($this->experience) && count($this->experience) > 0)
                <ul class="list-disc pl-6">
                    @foreach($this->experience as $exp)
                <li>
                <strong>{{ $exp['company'] }}</strong> - {{ $exp['role'] }} ({{ $exp['years'] }})
                </li>
                @endforeach
                </ul>
                @else
                <p>No work experience available</p>
                @endif
            </div>
            
            <div class="mb-4">
                <p > <strong>Work Experience</strong></p>
                @if(is_array($this->education) && count($this->education) > 0)
                    <ul class="list-disc pl-6">
                        @foreach($this->education as $edu)
                            <li>
                                <strong>{{ $edu['degree'] }}</strong> - {{ $edu['institution'] }} 
                                @if(!is_null($edu['gpa'])) (GPA: {{ $edu['gpa'] }}) @endif
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No education information available</p>
                @endif
            </div>
            
            <!-- Education -->
            {{-- <div class="mb-4">
                <h3 class="text-xl font-semibold">Education</h3>
                @foreach(json_decode($candidate->education, true) as $edu)
                    <p><strong>{{ $edu['degree'] }}</strong> - {{ $edu['institution'] }} (GPA: {{ $edu['gpa'] ?? 'N/A' }})</p>
                @endforeach
            </div>   --}}
        
            <!-- Back Button -->
            {{-- <flux:button wire:click="goBack" variant="secondary">Back</flux:button> --}}
        </div>
        
    </div> 
    </flux:modal>
</div>
