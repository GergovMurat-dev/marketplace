<?php

namespace App\UseCases\Commands;

use App\DTO\User\UserCreateDTO;
use App\Models\User;
use App\Utils\OperationResult;
use Illuminate\Support\Facades\Validator;
use Psr\Log\LoggerInterface;

class AuthCommandRegistration
{
    public function __construct(
        private readonly LoggerInterface $logger,
    )
    {
    }

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
                message: __('messages.incorrect_data'),
                errors: $v->errors()->toArray()
            );
        }

        $userCreateDTO = UserCreateDTO::make($data);

        $getUserOperationResult = $this->getUser($userCreateDTO);

        if ($getUserOperationResult->isError) {
            return $getUserOperationResult;
        }

        /** @var User $user */
        $user = $getUserOperationResult->data;

        if ($user->isConfirmedEmail) {
            return OperationResult::error(
                message: 'Данная электронная почта уже подтверждена'
            );
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return OperationResult::success(['token' => $token]);
    }

    private function getUser(
        UserCreateDTO $userCreateDTO
    ): OperationResult
    {
        try {
            $user = User::query()->firstOrCreate(
                [
                    'email' => $userCreateDTO->email
                ],
                $userCreateDTO->toArrayAsSnakeCase()
            );

            if (is_null($user)) {
                return OperationResult::error(
                    message: __('messages.incorrect_data')
                );
            }

            return OperationResult::success(
                $user
            );
        } catch (\Exception $e) {
            $this->logger->error(
                $e->getMessage()
            );
            return OperationResult::error(
                message: __('Произошла непредвиденная ошибка')
            );
        }
    }
}
