<?php

namespace App\Http\Controllers\Dashboard;

use App\Ai\Agents\GeneratePostContent;
use App\Ai\Agents\WriterAgent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Ai\Enums\Lab;

class AiWriteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $prompt = "Write a complete blog post about: {$request->message} but i use tinymce.init";

        // SSE response
        return GeneratePostContent::make()->stream(
            prompt: $prompt,
            provider: Lab::Groq,
            model: 'openai/gpt-oss-20b',
        );
    }
}