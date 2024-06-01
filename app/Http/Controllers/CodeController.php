<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CodeController extends Controller
{
    public function generateCodes($nr): JsonResponse
    {
        $codes = [];

        for ($i = 0; $i < $nr; $i++) {
            $code = Code::createUniqueCode();
            $codes[] = $code->value;
        }

        return response()->json(['codes' => $codes], 201);
    }

    public function checkCodeAndStart(Request $request): JsonResponse
    {
       $request->validate([
           'code' => 'required|max:6|min:6',
       ]);

        $code = Code::where('value', $request->code)->first();

        if ($code) {
            if (($code->start_used && $code->finish_used) !== true) {
                $code->update([
                    'start_used' => true,
                    'start_used_date' => date('Y-m-d H:i:s'),
                    'user_id' => $request->user()['id']
                ]);
            } else {
                return response()->json(['message' => 'Code expired!'], 200);
            }
            return response()->json(['message' => 'You are in!'], 200);
        } else {
            return response()->json(['message' => 'Code is invalid'], 404);
        }
    }

    public function finishGame(Request $request): JsonResponse
    {
       $request->validate([
           'code' => 'required|max:6|min:6',
           'score' => 'required',
           'video_url' => 'required',
       ]);

        $code = Code::where('value', $request->code)->first();

        if ($code) {
            if (($code->start_used === true) && ($code->finish_used !== true)) {
                $code->update([
                    'score' => $request->score,
                    'finish_used' => true,
                    'finish_used_date' => date('Y-m-d H:i:s'),
                    'video_url' => $request->video_url
                ]);
                $user = User::where('id', $request->user()['id'])->first();
                $totalScore = $user->total_score;
                $user->update([
                    'total_score' => ((int)$totalScore + $request->score)
                ]);
            } else {
                return response()->json(['message' => 'Game already played!'], 200);
            }
            return response()->json(['message' => 'Thanks!'], 200);
        } else {
            return response()->json(['message' => 'Code is invalid'], 404);
        }
    }
}
