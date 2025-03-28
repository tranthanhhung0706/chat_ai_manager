<?php

namespace App\Livewire;

use Livewire\Component;
use OpenAI;
use Flux;
class ChatBox extends Component
{
    public $messages = [];
    public $inputMessage;

    public function sendMessage()
    {
        if (!$this->inputMessage) return;

        // Thêm tin nhắn của người dùng vào danh sách tin nhắn
        $this->messages[] = ['role' => 'user', 'content' => $this->inputMessage];

        // Gọi OpenAI API để lấy phản hồi
        $client = OpenAI::client(env('OPENAI_API_KEY'));
        $response = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => $this->messages,
        ]);

        // Thêm phản hồi từ AI vào danh sách tin nhắn
        $this->messages[] = [
            'role' => 'assistant',
            'content' => $response['choices'][0]['message']['content']
        ];

        // Xóa nội dung nhập
        $this->inputMessage = '';
    }

    public function render()
    {
        return view('livewire.chat-box');
    }
}
