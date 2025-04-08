<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI;

use Symfony\Component\HttpFoundation\StreamedResponse;
class OpenAIStreamAssitantsController extends Controller
{
    public function streamChat(Request $request)
    {
        $openai = OpenAI::client(env('OPENAI_API_KEY'));

        // 1. Create a Thread
        //$thread = $openai->threads()->create();
        $thread = $openai->threads()->create([]);
        $threadId = $thread['id'];
        // 2. Add the User's Message
        $openai->threads()->messages()->create($threadId,
        [
            'role' => 'user',
            'content' => $request->input('message'),
        ]);
        return new StreamedResponse(function () use ($threadId,$openai) {
            
            $run = $openai->threads()->runs()->createStreamed($threadId, [
                'assistant_id' => env('OPENAI_ASSISTANT_ID'),
            ]);
            
            foreach ($run as $response) {
                // echo "data: " . json_encode($response->response) . "\n\n";
                // ob_flush();
                // flush();

                $data = json_decode(json_encode($response->response), true);
                
                if (isset($data['delta']['content']) && is_array($data['delta']['content'])) {
                    foreach ($data['delta']['content'] as $content) {
                        if ($content['type'] === 'text' && isset($content['text']['value'])) {
                            echo "data: \"" . $content['text']['value'] . "\"\n\n";
                            ob_flush();
                            flush();
                        }
                    }
                }
            
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
        ]);
        
    }
}
