<?php

use Illuminate\Support\Facades\Http;

// if (! function_exists('proc_sound2')) {
//     function proc_sound2()
//     {
//         $response = Http::withHeaders([
//             'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
//             'Accept' => '*/*',
//             'Origin' => 'https://ttsfree.com',
//             'Referer' => 'https://ttsfree.com/text-to-speech',
//         ])->get('https://stream207.ttsfree.com/voice/tts/process.php?id=j446a6v5z544i524s50636j4j606k5h41616h4l596u516i4y5x57644x5j4h536y5z5v5362676t54444o536u5f6j4f6v5a64464m264d4e4o4s4h474r4a434n294n4');

//         $body = $response->body();

//         // ambil bagian "data: { ... }"
//         if (preg_match('/data:\s*(\{.*\})/s', $body, $matches)) {
//             $jsonString = $matches[1];

//             // decode JSON bagian dalam
//             $decoded = json_decode($jsonString, true);

//             if (isset($decoded['player'])) {
//                 $player = $decoded['player'];

//                 // ambil src dari HTML escaped
//                 if (preg_match('/https:\\\\/\\\\/[^\\\\]+\.mp3\?file=\d+/', $player, $mp3Match)) {
//                     // bersihin backslash
//                     $audioUrl = stripslashes($mp3Match[0]);

//                     return response()->json([
//                         'status' => 'success',
//                         'audio_url' => $audioUrl,
//                     ]);
//                 }
//             }
//         }

//         return response()->json([
//             'status' => 'failed',
//             'message' => 'Audio URL not found',
//             'raw' => $body,
//         ], 500);
//     }

// }
