{{-- 
<div>
    <div class="flex flex-col p-4 border rounded shadow" style="width: 700px;">
        <div class="h-96 overflow-y-auto border-b mb-4">
            @foreach($messages as $index => $message)
                <div class="p-2 @if($message['role'] == 'user') text-right @else text-left @endif">
                    <strong>{{ ucfirst($message['role']) }}:</strong> 
                    <span id="message-{{ $index }}">{{ $message['content'] }}</span>
                </div>
            @endforeach
        </div>
        
        <div class="flex gap-2">
            <flux:input type="text" wire:model="inputMessage" placeholder="Type your message..." class="flex-1" />
            <flux:button wire:click="sendMessage" variant="primary">Send</flux:button>
        </div>
    </div>
</div>

<script>
    Livewire.on('updateMessage', (message) => {
        let lastIndex = document.querySelectorAll('[id^="message-"]').length - 1;
        let lastMessage = document.getElementById('message-' + lastIndex);
        if (lastMessage) {
            lastMessage.innerText = message;
        }
    });
</script>


 --}}

 <div>
    <div class="flex flex-col p-4 border rounded shadow" style="width: 700px;">
        <div class="h-96 overflow-y-auto border-b mb-4">
            @foreach($messages as $index => $message)
                <div class="p-2 @if($message['role'] == 'user') text-right @else text-left @endif">
                    <strong>{{ ucfirst($message['role']) }}:</strong> 
                    <span id="message-{{ $index }}">{{ $message['content'] }}</span>
                </div>
            @endforeach
        </div>

        <div class="flex gap-2">
            <flux:input type="text" wire:model="inputMessage" placeholder="Trả lời câu hỏi..." class="flex-1" />
            <flux:button wire:click="sendMessage" variant="primary">Gửi</flux:button>
        </div>
    </div>
</div>
