<?php

namespace App\services;

use App\Models\AdminModel\SystemFlag;
use App\Models\AiAstrologerModel\AiAstrologer;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Exception;

class ApiOpenAIService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $api_key = SystemFlag::where('name', 'OpenAiKey')->first();
        $this->apiKey = $api_key->value;
        if (!$this->apiKey) {
            \Log::error('OpenAI API Key not found');
            throw new Exception('API Key not found.');
        }
    }

    public function askChatGPT($message, $astrologerId, $imageBase64 = null)
    {
        $assistantContent = $this->getAssistantContentBasedOnAstrologer($astrologerId);
        $userId = Auth::guard('api')->user()->id;

        $assistantContent .= "\n[CRITICAL CHAT STYLE INSTRUCTION:
1. You must respond exactly like a warm, empathetic, human Indian astrologer chatting on a messaging app. Do NOT sound like an AI assistant. Never mention being an AI, chatbot, or language model.
2. Do NOT use structured bullet points, numbered lists, markdown titles, bold headings, or formatted dividers. Respond in a natural, fluid, and simple conversational paragraph style, just like a real person typing in a chat room.
3. ABSOLUTELY DO NOT start your response with a greeting like 'Namaste', 'Hello', 'Welcome' or repeat the user's name (e.g., 'Manish Ji') in every turn. Only greet the user ONCE if their message is an initial greeting (like 'hi', 'hello', 'namaste'). For all other messages, answer the user's question directly.
4. KEEP YOUR RESPONSES VERY SHORT AND CONCISE (maximum 2-3 short sentences, under 60 words). Do NOT write a long essay ('ramayan') or explain everything at once.
5. Answer ONLY the specific question the user asks. Leave details for the user to ask follow-up questions.
6. Always end your response with a short, relevant question to encourage the user to continue the conversation (e.g., 'Kya aap iske baare mein aur jaanna chahte hain?').
7. Respond in the same language the user uses (usually Simple Hindi or Hinglish).
8. IMPORTANT: If you are a palmist, palm reading expert, or palmistry specialist, and the user has NOT uploaded/attached an image of their palm in this message, you MUST politely ask them to upload a clear photo of their palm first so you can read it. Do NOT make up, guess, or hallucinate palm line readings if no image is attached.]";

        // Find the active conversation for this user and astrologer
        $conversation = \Illuminate\Support\Facades\DB::table('ai_conversations')
            ->where('user_id', $userId)
            ->where('ai_astrologer_id', $astrologerId)
            ->where('status', 'active')
            ->first();

        if (!$conversation) {
            $conversationId = (string) \Illuminate\Support\Str::uuid();
            \Illuminate\Support\Facades\DB::table('ai_conversations')->insert([
                'conversation_id' => $conversationId,
                'user_id' => $userId,
                'ai_astrologer_id' => $astrologerId,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $conversationId = $conversation->conversation_id;
        }

        // Check if first message in conversation to prepend user info
        $isFirst = \Illuminate\Support\Facades\DB::table('ai_messages')
            ->where('conversation_id', $conversationId)
            ->count() == 0;

        if ($isFirst) {
            $user = User::where('id', $userId)->select(['name', 'birthDate', 'birthPlace'])->first();
            $userInfo = "mera name {$user->name}, mera date of birth {$user->birthDate}, aur mera place of birth is {$user->birthPlace}.";
            $messageContent = "{$userInfo} {$message}";
        } else {
            $messageContent = $message;
        }

        \Illuminate\Support\Facades\DB::table('ai_messages')->insert([
            'conversation_id' => $conversationId,
            'role' => 'user',
            'content' => $messageContent,
            'image' => $imageBase64,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $history = \Illuminate\Support\Facades\DB::table('ai_messages')
            ->where('conversation_id', $conversationId)
            ->orderBy('created_at', 'asc')
            ->get();

        $messagesPayload = [
            ['role' => 'system', 'content' => $assistantContent]
        ];

        $hasImage = false;
        foreach ($history as $msg) {
            if ($msg->image) {
                $hasImage = true;
                $imgData = $msg->image;
                if (preg_match('/^data:image\/(\w+);base64,/', $imgData, $type)) {
                    $imgData = substr($imgData, strpos($imgData, ',') + 1);
                }
                $messagesPayload[] = [
                    'role' => $msg->role,
                    'content' => [
                        [
                            'type' => 'text',
                            'text' => $msg->content
                        ],
                        [
                            'type' => 'image_url',
                            'image_url' => [
                                'url' => 'data:image/jpeg;base64,' . $imgData
                            ]
                        ]
                    ]
                ];
            } else {
                $messagesPayload[] = [
                    'role' => $msg->role,
                    'content' => $msg->content
                ];
            }
        }

        if ($hasImage) {
            $assistantContent .= "\n[SYSTEM INSTRUCTION OVERRIDE: The user has attached an image of their palm. You are equipped with vision capabilities and can view the image. Please analyze their palm lines (Heart line, Life line, Head line, etc.) based on the image provided and provide a detailed palmistry reading. Ignore any previous instructions claiming you cannot see or analyze images.]";
            $messagesPayload[0]['content'] = $assistantContent;
        }

        try {
            $payload = [
                'model' => $hasImage ? 'gpt-4o' : 'gpt-4',
                'temperature' => 0.5,
                'top_p' => 0.7,
                'max_tokens' => 500,
                'frequency_penalty' => 0,
                'presence_penalty' => 0,
                'messages' => $messagesPayload,
            ];

            $response = $this->client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => $payload,
            ]);

            $data = json_decode($response->getBody(), true);
            $content = $data['choices'][0]['message']['content'];

            \Illuminate\Support\Facades\DB::table('ai_messages')->insert([
                'conversation_id' => $conversationId,
                'role' => 'assistant',
                'content' => trim($content),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return trim($content);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            \Log::error('Request error: ' . $e->getMessage());
            return 'Error communicating with OpenAI API.';
        } catch (Exception $e) {
            \Log::error('General error: ' . $e->getMessage());
            return $e->getMessage();
        }
    }

    public function askChatGPTMaster($message)
    {
        $assistantContent = AiAstrologer::where('type', 'master')->value('system_intruction');
        $assistantContent .= "\n[CRITICAL CHAT STYLE INSTRUCTION:
1. You must respond exactly like a warm, empathetic, human Indian astrologer chatting on a messaging app. Do NOT sound like an AI assistant. Never mention being an AI, chatbot, or language model.
2. Do NOT use structured bullet points, numbered lists, markdown titles, bold headings, or formatted dividers. Respond in a natural, fluid, and simple conversational paragraph style, just like a real person typing in a chat room.
3. ABSOLUTELY DO NOT start your response with a greeting like 'Namaste', 'Hello', 'Welcome' or repeat the user's name (e.g., 'Manish Ji') in every turn. Only greet the user ONCE if their message is an initial greeting (like 'hi', 'hello', 'namaste'). For all other messages, answer the user's question directly.
4. KEEP YOUR RESPONSES VERY SHORT AND CONCISE (maximum 2-3 short sentences, under 60 words). Do NOT write a long essay ('ramayan') or explain everything at once.
5. Answer ONLY the specific question the user asks. Leave details for the user to ask follow-up questions.
6. Always end your response with a short, relevant question to encourage the user to continue the conversation (e.g., 'Kya aap iske baare mein aur jaanna chahte hain?').
7. Respond in the same language the user uses (usually Simple Hindi or Hinglish).]";

        $userId = Auth::guard('api')->user()->id;
        $astrologerId = 0; // 0 for Master AI

        $conversation = \Illuminate\Support\Facades\DB::table('ai_conversations')
            ->where('user_id', $userId)
            ->where('ai_astrologer_id', $astrologerId)
            ->where('status', 'active')
            ->first();

        if (!$conversation) {
            $conversationId = (string) \Illuminate\Support\Str::uuid();
            \Illuminate\Support\Facades\DB::table('ai_conversations')->insert([
                'conversation_id' => $conversationId,
                'user_id' => $userId,
                'ai_astrologer_id' => $astrologerId,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $conversationId = $conversation->conversation_id;
        }

        // Check if first message in conversation to prepend user info
        $isFirst = \Illuminate\Support\Facades\DB::table('ai_messages')
            ->where('conversation_id', $conversationId)
            ->count() == 0;

        if ($isFirst) {
            $user = Auth::guard('api')->user();
            $userInfo = "Name: {$user->name}, DOB: {$user->birthDate}, Place: {$user->birthPlace}";
            $messageContent = "User details (reference only): {$userInfo}\nQuestion: {$message}";
        } else {
            $messageContent = $message;
        }

        \Illuminate\Support\Facades\DB::table('ai_messages')->insert([
            'conversation_id' => $conversationId,
            'role' => 'user',
            'content' => $messageContent,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $history = \Illuminate\Support\Facades\DB::table('ai_messages')
            ->where('conversation_id', $conversationId)
            ->orderBy('created_at', 'asc')
            ->get();

        $messagesPayload = [
            ['role' => 'system', 'content' => $assistantContent]
        ];

        foreach ($history as $msg) {
            $messagesPayload[] = [
                'role' => $msg->role,
                'content' => $msg->content
            ];
        }

        try {
            $response = $this->client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-4',
                    'messages' => $messagesPayload,
                    'temperature' => 0.2,
                    'top_p' => 0.5,
                    'max_tokens' => 500,
                ],
            ]);

            $content = json_decode($response->getBody(), true)['choices'][0]['message']['content'];

            \Illuminate\Support\Facades\DB::table('ai_messages')->insert([
                'conversation_id' => $conversationId,
                'role' => 'assistant',
                'content' => trim($content),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return trim($content);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            \Log::error('Request error: ' . $e->getMessage());
            return 'Error communicating with OpenAI API.';
        } catch (Exception $e) {
            \Log::error('AI Error: ' . $e->getMessage());
            return 'AI service temporarily unavailable.';
        }
    }

    private function stopAtLastPeriod($content)
    {
        // Trim any extra spaces from the content
        $content = trim($content);

        // Split the content into lines
        $lines = explode("\n", $content);

        // Remove the last line if it exists
        if (!empty($lines)) {
            array_pop($lines);
        }

        // Join the remaining lines back into a single string
        $content = implode("\n", $lines);

        // Return the modified content
        return $content;
    }

    private function getAssistantContentBasedOnAstrologer($astrologerId)
    {
        $astrologer = AiAstrologer::find($astrologerId);

        if ($astrologer) {
            return $astrologer->system_intruction;
        }
        return "You are an experienced astrologer. Your role is to provide insightful and personalized
          astrological readings based on users' birth details. Use your knowledge of astrology to interpret planetary
           positions, aspects, and transits to help users understand their past, present, and future. Be empathetic
            and supportive in your responses.";
    }
}
