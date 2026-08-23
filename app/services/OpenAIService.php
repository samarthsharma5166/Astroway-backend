<?php

namespace App\Services;

use App\Models\AdminModel\SystemFlag;
use GuzzleHttp\Client;
use Exception;
use App\Models\AiAstrologerModel\AiAstrologer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OpenAIService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $api_key=SystemFlag::where('name','OpenAiKey')->first();
        $this->apiKey = $api_key->value;
        if (!$this->apiKey) {
            \Log::error('OpenAI API Key not found');
            throw new Exception('API Key not found.');
        }
    }

    public function askChatGPT($message,$astrologerId)
    {

        $assistantContent = $this->getAssistantContentBasedOnAstrologer($astrologerId); // Example function to get dynamic content based on astrologer ID
        $assistantContent .= "\n[CRITICAL CHAT STYLE INSTRUCTION:
1. You must respond exactly like a warm, empathetic, human Indian astrologer chatting on a messaging app. Do NOT sound like an AI assistant. Never mention being an AI, chatbot, or language model.
2. Do NOT use structured bullet points, numbered lists, markdown titles, bold headings, or formatted dividers. Respond in a natural, fluid, and simple conversational paragraph style, just like a real person typing in a chat room.
3. ABSOLUTELY DO NOT start your response with a greeting like 'Namaste', 'Hello', 'Welcome' or repeat the user's name (e.g., 'Manish Ji') in every turn. Only greet the user ONCE if their message is an initial greeting (like 'hi', 'hello', 'namaste'). For all other messages, answer the user's question directly.
4. KEEP YOUR RESPONSES VERY SHORT AND CONCISE (maximum 2-3 short sentences, under 60 words). Do NOT write a long essay ('ramayan') or explain everything at once.
5. Answer ONLY the specific question the user asks. Leave details for the user to ask follow-up questions.
6. Always end your response with a short, relevant question to encourage the user to continue the conversation (e.g., 'Kya aap iske baare mein aur jaanna chahte hain?').
7. Respond in the same language the user uses (usually Simple Hindi or Hinglish).
8. IMPORTANT: If you are a palmist, palm reading expert, or palmistry specialist, and the user has NOT uploaded/attached an image of their palm in this message, you MUST politely ask them to upload a clear photo of their palm first so you can read it. Do NOT make up, guess, or hallucinate palm line readings if no image is attached.]";
        $userId = authcheck()['id'];
        $user = User::where('id', $userId)->select(['name', 'birthDate', 'birthPlace'])->first();
        
        // Format the user data into the message
        $userInfo = "mera name {$user->name}, mera date of birth {$user->birthDate}, aur mera place of birth is {$user->birthPlace}.";
        $finalMessage = "{$userInfo} {$message}";

        try {
            $response = $this->client->post('https://api.openai.com/v1/chat/completions', [

                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type'  => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-4',
                    'messages' => [
                        ['role' => 'system', 'content' => $assistantContent],
                        ['role' => 'user', 'content' => $finalMessage],
                    ],
                    'max_tokens' => 200,
                    'temperature' => 0.5,
                    'top_p' => 0.7,
                    'frequency_penalty'=>0,
                    'presence_penalty'=>0,
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            $content = $data['choices'][0]['message']['content'];
            $content = $this->stopAtLastPeriod($content);

            return $content;
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
        $assistantContent = AiAstrologer::where('type','master')->value('system_intruction');
        $assistantContent .= "\n[CRITICAL CHAT STYLE INSTRUCTION:
1. You must respond exactly like a warm, empathetic, human Indian astrologer chatting on a messaging app. Do NOT sound like an AI assistant. Never mention being an AI, chatbot, or language model.
2. Do NOT use structured bullet points, numbered lists, markdown titles, bold headings, or formatted dividers. Respond in a natural, fluid, and simple conversational paragraph style, just like a real person typing in a chat room.
3. ABSOLUTELY DO NOT start your response with a greeting like 'Namaste', 'Hello', 'Welcome' or repeat the user's name (e.g., 'Manish Ji') in every turn. Only greet the user ONCE if their message is an initial greeting (like 'hi', 'hello', 'namaste'). For all other messages, answer the user's question directly.
4. KEEP YOUR RESPONSES VERY SHORT AND CONCISE (maximum 2-3 short sentences, under 60 words). Do NOT write a long essay ('ramayan') or explain everything at once.
5. Answer ONLY the specific question the user asks. Leave details for the user to ask follow-up questions.
6. Always end your response with a short, relevant question to encourage the user to continue the conversation (e.g., 'Kya aap iske baare mein aur jaanna chahte hain?').
7. Respond in the same language the user uses (usually Simple Hindi or Hinglish).]";
        $userId = authcheck()['id'];
        $user = User::where('id', $userId)->select(['name', 'birthDate', 'birthPlace'])->first();
        
        // $userInfo = "My name is {$user->name}, my date of birth is {$user->birthDate}, and my place of birth is {$user->birthPlace}.";
        $userInfo = "mera name {$user->name}, mera date of birth {$user->birthDate}, aur mera place of birth is {$user->birthPlace}.";

        $finalMessage = "{$userInfo} {$message}";

        try {
            $response = $this->client->post('https://api.openai.com/v1/chat/completions', [

                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type'  => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-4',
                    'messages' => [
                        ['role' => 'system', 'content' => $assistantContent],
                        ['role' => 'user', 'content' => $finalMessage],
                    ],
                    'max_tokens' => 350,
                    'temperature' => 0.5,
                    'top_p' => 0.7,
                    'frequency_penalty'=>0,
                    'presence_penalty'=>0,
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            $content = $data['choices'][0]['message']['content'];
            $content = $this->stopAtLastPeriod($content);

            return $content;
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

    private function stopAtLastPeriod($content)
    {
        // Trim any extra spaces from the response
        $content = trim($content);

        // Find the position of the last period (.)
        $lastPeriodPos = strrpos($content, '.');

        // If a period is found, truncate everything after the last period
        if ($lastPeriodPos !== false) {
            // Cut the response to the position of the last period
            $content = substr($content, 0, $lastPeriodPos + 1);
        }

        // Return the trimmed content
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
