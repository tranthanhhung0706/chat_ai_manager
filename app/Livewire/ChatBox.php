<?php

namespace App\Livewire;

use Livewire\Component;
use OpenAI;
use Flux;
class ChatBox extends Component
{
    // public $messages = [];
    // public $inputMessage;

    // public function sendMessage()
    // {
    //     if (!$this->inputMessage) return;

    //     // Thêm tin nhắn của người dùng vào danh sách tin nhắn
    //     $this->messages[] = ['role' => 'user', 'content' => $this->inputMessage];

    //     // Gọi OpenAI API để lấy phản hồi
    //     $client = OpenAI::client(env('OPENAI_API_KEY'));


    //     $thread = $client->threads()->create([]);
    //     $threadId = $thread['id'];
        
    //     $client->threads()->messages()->create($threadId,
    //     [
    //         'role' => 'user',
    //         'content' =>$this->inputMessage,
    //     ]);

    //     $run = $client->threads()->runs()->createStreamed($threadId, [
    //         'assistant_id' => env('OPENAI_ASSISTANT_ID'),
    //     ]);
    
    //     $responseText = '';
    //     foreach ($run as $response) {
    //         $data = json_decode(json_encode($response->response), true);

    //         if (isset($data['delta']['content']) && is_array($data['delta']['content'])) {
    //             foreach ($data['delta']['content'] as $content) {
    //                 if ($content['type'] === 'text' && isset($content['text']['value'])) {
    //                     $responseText .= $content['text']['value'];

    //                     // Cập nhật tin nhắn theo thời gian thực
    //                     $this->dispatch('updateMessage', $responseText);
    //                 }
    //             }
    //         }
    //     }

    //     $this->messages[] = ['role' => 'assistant', 'content' => $responseText];

    //     $this->inputMessage = '';
    // }
    public $messages = [];
    public $inputMessage = '';
    public $currentQuestionIndex = 0;
    public $questions = [
        "Hãy giới thiệu bản thân bạn.",
        "Bạn có kinh nghiệm gì trong lĩnh vực này?",
        "Bạn có thể làm việc nhóm tốt không?",
        "Bạn mong muốn mức lương bao nhiêu?"
    ];

    public function sendMessage()
    {
        if (!$this->inputMessage) return;

        // Lưu câu trả lời của ứng viên
        $this->messages[] = ['role' => 'user', 'content' => $this->inputMessage];

        // Tạo client OpenAI
        $client = OpenAI::client(env('OPENAI_API_KEY'));

        // Gửi câu trả lời của ứng viên để bot đánh giá và phản hồi
        $response = $client->chat()->create([
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'system', 'content' => 'Bạn là một nhà tuyển dụng đang phỏng vấn ứng viên.'],
                ['role' => 'user', 'content' => $this->inputMessage]
            ]
        ]);

        // Lấy câu trả lời của bot
        //dd($response['choices'][0]['message']['content']);
        $botResponse = $response['choices'][0]['message']['content'];
        
        // Lưu phản hồi của bot vào danh sách tin nhắn
        $this->messages[] = ['role' => 'assistant', 'content' => $botResponse];

        // Tiếp tục với câu hỏi tiếp theo
        if ($this->currentQuestionIndex < count($this->questions) - 1) {
            $this->currentQuestionIndex++;
            $this->messages[] = ['role' => 'assistant', 'content' => $this->questions[$this->currentQuestionIndex]];
        }

        // Xóa input sau khi gửi
        $this->inputMessage = '';
    }

    public function render()
    {
        return view('livewire.chat-box');
    }
}
