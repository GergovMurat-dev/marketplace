<?php

namespace App\UseCases\Commands;

use App\DTO\User\UserCreateDTO;
use App\Models\User;
use App\Utils\OperationResult;
use Illuminate\Support\Facades\Validator;

class AuthCommandRegistration
{
    public function handle(array $data): OperationResult
    {
        $v = Validator::make(
            $data,
            [
                'email' => 'required|email',
                'name' => 'required',
                'password' => 'required|min:8'
            ]
        );

        if ($v->fails()) {
            return OperationResult::error(
                message: 'Введены не корректные данные',
                errors: $v->errors()->toArray()
            );
        }

        $userCreateDTO = UserCreateDTO::make($data);

        $user = $this->getUser($userCreateDTO);

        $token = $user->createToken('auth_token')->plainTextToken;

        return OperationResult::success(['token' => $token]);
    }

    private function getUser(
        UserCreateDTO $userCreateDTO
    ): User
    {
        /** @var User $user */
        $user = User::query()->firstOrCreate(
            [
                'email' => $userCreateDTO->email
            ],
            $userCreateDTO->toArrayAsSnakeCase()
        );

        return $user;
    }
}
