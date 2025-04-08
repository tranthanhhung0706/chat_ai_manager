<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use OpenAI;
class ChatController extends Controller
{
    public function streamChat(Request $request)
    {
        $client = OpenAI::client(env('OPENAI_API_KEY'));

        // Create a new thread
        $thread = $client->threads()->create([]);
        $threadId = $thread['id'];

        // Add the user's message to the thread
        $client->threads()->messages()->create($threadId, [
            'role' => 'user',
            'content' => $request->input('message'),
        ]);

        // Return a StreamedResponse
        return new StreamedResponse(function () use ($client, $threadId) {
            $stream = $client->threads()->runs()->createStreamed($threadId, [
                'assistant_id' => env('OPENAI_ASSISTANT_ID'),
            ]);

            // Process and send streamed data
            foreach ($stream as $response) {
                $data = json_decode(json_encode($response->response), true);

                if (isset($data['delta']['content']) && is_array($data['delta']['content'])) {
                    foreach ($data['delta']['content'] as $content) {
                        if ($content['type'] === 'text' && isset($content['text']['value'])) {
                            echo "data: " . json_encode(['text' => $content['text']['value']]) . "\n\n";
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
