<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\UseCases\Commands\AuthCommandRegistration;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request, AuthCommandRegistration $command)
    {
        $commandResult = $command->handle(
            $request->all()
        );

        if ($commandResult->isError) {
            return response()->json([
                'message' => $commandResult->message,
                'errors' => $commandResult->errors
            ], $commandResult->code);
        }

        return response()->json(
            $commandResult->data
        );
    }
}
