<?php

namespace App\Http\Controllers;

use App\Models\Code;
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

        $codeExists = Code::where('value', $request->code)->first();

        if ($codeExists) {
            $codeExists->update([
                'start_used' => true,
                'start_used_date' => date('Y-m-d H:i:s'),
                'user_id' => $request->user()['id']
            ]);
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
            $code->update([
                'score' => $request->score,
                'finish_used' => true,
                'finish_used_date' => date('Y-m-d H:i:s'),
                'video_url' => $request->video_url
            ]);
            return response()->json(['message' => 'Thanks!'], 200);
        } else {
            return response()->json(['message' => 'Code is invalid'], 404);
        }
    }
}
