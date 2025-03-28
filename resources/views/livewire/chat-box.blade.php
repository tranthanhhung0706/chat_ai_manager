<div>
    
    <div class="flex flex-col p-4 border rounded shadow" style="width: 700px;">
        <div class="h-64 overflow-y-auto border-b mb-4">
            @foreach($messages as $message)
                <div class="p-2 @if($message['role'] == 'user') text-right @else text-left @endif">
                    <strong>{{ ucfirst($message['role']) }}:</strong> {{ $message['content'] }}
                </div>
            @endforeach
        </div>
        
        <div class="flex gap-2">
            <flux:input type="text" wire:model="inputMessage" placeholder="Type your message..." class="flex-1" />
            <flux:button wire:click="sendMessage" variant="primary">Send</flux:button>
        </div>
    </div>
    
</div>
