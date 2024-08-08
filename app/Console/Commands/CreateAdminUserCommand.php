<?php

namespace App\Console\Commands;

use App\Enums\User\UserTypesEnum;
use App\Models\User;
use Illuminate\Console\Command;

class CreateAdminUserCommand extends Command
{
    protected $signature = 'app:create-admin-user-command';

    protected $description = 'Создание главного администратора';

    public function handle(): void
    {
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'type' => UserTypesEnum::admin,
            'password' => '1',
        ]);

        if (is_null($admin)) {
            $this->error(
                'При создании администратора произошла ошибка, повторите попытку позднее'
            );
            return;
        }

        $this->info('Администратор успешно создан');
    }
}
