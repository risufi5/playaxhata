<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUserData(Request $request)
    {
        $user = User::where('id', $request->user()['id'])->first();
        if ($user) {
            $userData = [
                'totalScore' => $user->total_score,
                'codes' => [$user->codes],
            ];
            return $userData;
        } else {
            return response()->json(['message' => 'User not found!'], 400);
        }
    }
}
