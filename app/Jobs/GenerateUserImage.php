<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GenerateUserImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Post $post)
    {
        // Passes the post model
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Use open router 
        try {
            $apiKey = env('OPENROUTER_API_KEY');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => 'google/gemini-2.5-flash',
                'max_tokens' => 4000,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => 'Create a nice image for post based on this title: ' . $this->post->title
                    ]
                ],
                'tools' => [
                    [
                        'type' => 'openrouter:image_generation',
                        'parameters'=>[
                             "model"=> "openai/gpt-5-image",
                              "quality"=> "high",
                              "aspect_ratio"=> "16:9",
                              "size"=> "1024x1024",
                              "background"=> "transparent",
                              "output_format"=> "png"
                        ]
                    ],
                    
                ]
            ]);

            $result = $response->json();
            \Log::info($result);

            // Check if status index exists and is ok to avoid undefined array key errors
            if (isset($result['status']) && $result['status'] === 'ok') {
                
                $imageUrl = $result['imageUrl'];
                
                // Fetch the actual image pixels from the URL
                $imageContent = @file_get_contents($imageUrl);

                if ($imageContent) {
                    // Create a unique random filename inside the posts directory
                    $imagePath = 'posts/' . Str::random(40) . '.png';
                    
                    // Save the physical file into your public storage directory
                    Storage::disk('public')->put($imagePath, $imageContent);

                    // Update the Database and commit it permanently
                    $this->post->cover_image = $imagePath;
                    $this->post->save();

                    \Log::info("Success! Image generated and saved at: " . $imagePath);
                } else {
                    throw new \Exception("Failed to download image contents from URL: " . $imageUrl);
                }
        
            } else {
                throw new \Exception("OpenRouter API Failed: " . $response->body());
            }

        } catch (\Exception $e) {
            \Log::error("Laravel HTTP Client Job Failed: " . $e->getMessage());
            
            // Fallback: If anything fails, save the default image so layout doesn't break
            $this->post->cover_image = "posts/default.jpg";
            $this->post->save();
            
            throw $e;
        }
    }
}