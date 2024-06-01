<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCodeRequest;
use App\Http\Requests\UpdateCodeRequest;
use App\Models\Code;
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
}
