<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    private function proc_sound2()
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
            'Accept' => '*/*',
            'Origin' => 'https://ttsfree.com',
            'Referer' => 'https://ttsfree.com/text-to-speech',
        ])->get('https://stream207.ttsfree.com/voice/tts/process.php?id=j446a6v5z544i524s50636j4j606k5h41616h4l596u516i4y5x57644x5j4h536y5z5v5362676t54444o536u5f6j4f6v5a64464n254d4k4s4i4k4b4o43474o294');

        $body = $response->body();

        if (preg_match('/data:\s*(\{.*\})/s', $body, $matches)) {
            $jsonString = $matches[1];
            $decoded = json_decode($jsonString, true);

            if (isset($decoded['player'])) {
                $player = $decoded['player'];

                if (preg_match('/https:\\/\\/[^\\\\"]+\.mp3\?file=\d+/', $player, $match)) {
                    $audioUrl = stripslashes($match[0]);

                    return response()->json([
                        'status' => 'success',
                        'audio_url' => $audioUrl,
                    ]);
                }
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Audio URL not found',
            'raw_response' => $body,
        ], 500);
    }

    public function testing(Request $request)
    {
        return response()->json([
            'message' => 'Testing successful.',
        ]);
    }

    public function register(Request $request)
    {
        try {

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => 'user',
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Registration failed.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function proc_sound(Request $request)
    {
        try {
            $request->validate([
                'text' => ['required', 'string'],
            ]);

            $response = Http::withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
                'Accept' => '*/*',
                'Origin' => 'https://ttsfree.com',
                'Referer' => 'https://ttsfree.com/text-to-speech',
            ])->asForm()->post('https://ttsfree.com/voice/tts/tts.php?t=1762107956618', [
                'input_text' => $request->text,
                'voice_service' => 'voice_bin',
                'process' => 'j446a6v5z544i524s50636j4j606k5h41616h4l596u516i4y5x57644x5j4h536y5z5v5362676t54444o536u5f6j4f6v5a64464n254d4k4s4i4k4b4o43474o294',
                'captcha_client' => '6Ldd91QfAAAAACSeHSLqVNGaphuA7cXfc3YCfNoR',
                'select_lang_google' => 'en-US',
                'voice_goo' => 'en-US-Standard-A',
                'action' => 'https%3A%2F%2Fttsfree.com%2Ftext-to-speech',
                'player_width' => '300',
                'select_lang_bin' => 'id-ID',
                'voice_bin' => 'id-ID2',
            ]);

            $body = trim($response->body());

            if (str_contains($body, 'finish||')) {
                $soundResponse = $this->proc_sound2();
                $soundData = json_decode($soundResponse->getContent(), true);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Request Success',
                    'sound' => $soundData,
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Request Failed',
            ], 500);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'TTS processing failed.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
