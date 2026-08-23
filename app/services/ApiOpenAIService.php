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
        $user = User::where('id', $userId)->select(['name', 'birthDate', 'birthPlace'])->first();

        $assistantContent .= "\n[CRITICAL CHAT STYLE INSTRUCTION:
1. You must respond exactly like a warm, empathetic, human Indian astrologer chatting on a messaging app. Do NOT sound like an AI assistant. Never mention being an AI, chatbot, or language model.
2. Do NOT use structured bullet points, numbered lists, markdown titles, bold headings, or formatted dividers. Respond in a natural, fluid, and simple conversational paragraph style, just like a real person typing in a chat room.
3. ABSOLUTELY DO NOT start your response with a greeting like 'Namaste', 'Hello', 'Welcome' or repeat the user's name (e.g., 'Manish Ji') in every turn. Only greet the user ONCE if their message is an initial greeting (like 'hi', 'hello', 'namaste'). For all other messages, answer the user's question directly.
4. KEEP YOUR RESPONSES VERY SHORT AND CONCISE (maximum 2-3 short sentences, under 60 words). Do NOT write a long essay ('ramayan') or explain everything at once.
5. Answer ONLY the specific question the user asks. Leave details for the user to ask follow-up questions.
6. Always end your response with a short, relevant question to encourage the user to continue the conversation (e.g., 'Kya aap iske baare mein aur jaanna chahte hain?').
7. Respond in the same language the user uses (usually Simple Hindi or Hinglish).
8. IMPORTANT: If you are a palmist, palm reading expert, or palmistry specialist, and the user has NOT uploaded/attached an image of their palm in this message, you MUST politely ask them to upload a clear photo of their palm first so you can read it. Do NOT make up, guess, or hallucinate palm line readings if no image is attached.]";

        // Format the user data into the message
        $userInfo = "mera name {$user->name}, mera date of birth {$user->birthDate}, aur mera place of birth is {$user->birthPlace}.";
        $finalMessage = "{$userInfo} {$message}";

        try {
            $payload = [
                'model' => $imageBase64 ? 'gpt-4o' : 'gpt-4',
                'temperature' => 0.5,
                'top_p' => 0.7,
                'max_tokens' => 500,
                'frequency_penalty' => 0,
                'presence_penalty' => 0,
            ];

            if ($imageBase64) {
                // strip out metadata scheme if present
                if (preg_match('/^data:image\/(\w+);base64,/', $imageBase64, $type)) {
                    $imageBase64 = substr($imageBase64, strpos($imageBase64, ',') + 1);
                }
                $assistantContent .= "\n[SYSTEM INSTRUCTION OVERRIDE: The user has attached an image of their palm. You are equipped with vision capabilities and can view the image. Please analyze their palm lines (Heart line, Life line, Head line, etc.) based on the image provided and provide a detailed palmistry reading. Ignore any previous instructions claiming you cannot see or analyze images.]";
                $payload['messages'] = [
                    ['role' => 'system', 'content' => $assistantContent],
                    [
                        'role' => 'user',
                        'content' => [
                            [
                                'type' => 'text',
                                'text' => $finalMessage
                            ],
                            [
                                'type' => 'image_url',
                                'image_url' => [
                                    'url' => 'data:image/jpeg;base64,' . $imageBase64
                                ]
                            ]
                        ]
                    ]
                ];
            } else {
                $payload['messages'] = [
                    ['role' => 'system', 'content' => $assistantContent],
                    ['role' => 'user', 'content' => $finalMessage],
                ];
            }

            $response = $this->client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => $payload,
            ]);

            $data = json_decode($response->getBody(), true);
            $content = $data['choices'][0]['message']['content'];
 
            return trim($content);
        } catch (RequestException $e) {
            if ($e->getCode() == 429) {
                $attempts++;
                sleep(2);
            } else {
                \Log::error('Request error: ' . $e->getMessage());
                return 'Error communicating with OpenAI API.';
            }
        } catch (Exception $e) {
            \Log::error('General error: ' . $e->getMessage());
            return $e->getMessage();
        }
    }

    public function askChatGPTMaster($message)
    {
        // Rule Instructions

        //     You are an expert astrologer.

        // Rules:
        // - Provide astrological insights strictly based on traditional astrological principles.
        // - Give guidance or predictions ONLY for career, love, health, and finance.
        // - Answer ONLY what is relevant to the user’s question.
        // - Keep the response short, clear, and focused.
        // - Do NOT add extra analysis, remedies, or predictions unless explicitly asked.
        // - If a question goes beyond astrological knowledge, respond exactly with:
        //   "This is beyond my limit as an astrologer."
        // - Respond in Hinglish (simple Hindi + English).

        $assistantContent = AiAstrologer::where('type', 'master')->value('system_intruction');
        $assistantContent .= "\n[CRITICAL CHAT STYLE INSTRUCTION:
1. You must respond exactly like a warm, empathetic, human Indian astrologer chatting on a messaging app. Do NOT sound like an AI assistant. Never mention being an AI, chatbot, or language model.
2. Do NOT use structured bullet points, numbered lists, markdown titles, bold headings, or formatted dividers. Respond in a natural, fluid, and simple conversational paragraph style, just like a real person typing in a chat room.
3. ABSOLUTELY DO NOT start your response with a greeting like 'Namaste', 'Hello', 'Welcome' or repeat the user's name (e.g., 'Manish Ji') in every turn. Only greet the user ONCE if their message is an initial greeting (like 'hi', 'hello', 'namaste'). For all other messages, answer the user's question directly.
4. KEEP YOUR RESPONSES VERY SHORT AND CONCISE (maximum 2-3 short sentences, under 60 words). Do NOT write a long essay ('ramayan') or explain everything at once.
5. Answer ONLY the specific question the user asks. Leave details for the user to ask follow-up questions.
6. Always end your response with a short, relevant question to encourage the user to continue the conversation (e.g., 'Kya aap iske baare mein aur jaanna chahte hain?').
7. Respond in the same language the user uses (usually Simple Hindi or Hinglish).]";

        $user = Auth::guard('api')->user();
        $userInfo = "Name: {$user->name}, DOB: {$user->birthDate}, Place: {$user->birthPlace}";

        try {
            $response = $this->client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-4.1',
                    'messages' => [
                        ['role' => 'system', 'content' => $assistantContent],
                        ['role' => 'user', 'content' => "User details (reference only): {$userInfo}"],
                        ['role' => 'user', 'content' => "Question: {$message}"],
                    ],
                    'temperature' => 0.2,
                    'top_p' => 0.5,
                    'max_tokens' => 500,
                ],
            ]);

            return trim(
                json_decode($response->getBody(), true)['choices'][0]['message']['content']
            );
        } catch (\Exception $e) {
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
