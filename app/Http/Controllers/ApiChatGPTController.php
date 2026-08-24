<?php

namespace App\Http\Controllers;
use Auth;
use App\services\ApiOpenAIService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ApiChatGPTController extends Controller
{
    protected $apiOpenAIService;
    
    public function __construct(ApiOpenAIService $apiOpenAIService)
    {
        $this->apiOpenAIService = $apiOpenAIService;
    }
    
    public function getActiveSession(Request $request)
    {
        $validated = $request->validate([
            'astrologerId' => 'required'
        ]);

        if (!Auth::guard('api')->user()) {
            return response()->json([
                'message' => 'Access Denied: You must be logged in to view this page. Please log in to continue.',
                'status'  => 403,
            ], 403);
        }

        $userId = Auth::guard('api')->user()->id;
        $astrologerId = $validated['astrologerId'];

        $conversation = DB::table('ai_conversations')
            ->where('user_id', $userId)
            ->where('ai_astrologer_id', $astrologerId)
            ->where('status', 'active')
            ->first();

        if (!$conversation) {
            $conversationId = (string) Str::uuid();
            DB::table('ai_conversations')->insert([
                'conversation_id' => $conversationId,
                'user_id' => $userId,
                'ai_astrologer_id' => $astrologerId,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $messages = [];
        } else {
            $conversationId = $conversation->conversation_id;
            $messages = DB::table('ai_messages')
                ->where('conversation_id', $conversationId)
                ->orderBy('created_at', 'asc')
                ->get()
                ->map(function($msg) {
                    return [
                        'text' => $msg->content,
                        'isFromUser' => $msg->role === 'user',
                        'imageBase64' => $msg->image,
                    ];
                });
        }

        return response()->json([
            'conversation_id' => $conversationId,
            'messages' => $messages,
            'status' => 200
        ], 200);
    }

    public function exitSession(Request $request)
    {
        $validated = $request->validate([
            'astrologerId' => 'required'
        ]);

        if (!Auth::guard('api')->user()) {
            return response()->json([
                'message' => 'Access Denied: You must be logged in to view this page. Please log in to continue.',
                'status'  => 403,
            ], 403);
        }

        $userId = Auth::guard('api')->user()->id;
        $astrologerId = $validated['astrologerId'];

        DB::table('ai_conversations')
            ->where('user_id', $userId)
            ->where('ai_astrologer_id', $astrologerId)
            ->where('status', 'active')
            ->update([
                'status' => 'closed',
                'updated_at' => now()
            ]);

        return response()->json([
            'message' => 'Session ended successfully',
            'status' => 200
        ], 200);
    }

    public function ask(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string',
            'astrologerId' => 'required',
            'image' => 'nullable|string'
        ]);
        
        if (Auth::guard('api')->user()) {
            $response = $this->apiOpenAIService->askChatGPT(
                $validated['message'], 
                $validated['astrologerId'],
                $request->input('image')
            );

            return response()->json([
                'message' => $response,
                'status'  => 200,
            ],200);
        } else {
            return response()->json([
                'message' => 'Access Denied: You must be logged in to view this page. Please log in to continue.',
                'status'  => 403,
                ], 403);
            
        }
    }

    public function askMaster(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string',
        ]);
        
        if (Auth::guard('api')->user()) {
            $response = $this->apiOpenAIService->askChatGPTMaster($validated['message']);

            return response()->json([
                'message' => $response,
                'status'  => 200,
            ],200);
        } else {
            return response()->json([
                'message' => 'Access Denied: You must be logged in to view this page. Please log in to continue.',
                'status'  =>403,
            ], 403);
            
        }
    }
}
