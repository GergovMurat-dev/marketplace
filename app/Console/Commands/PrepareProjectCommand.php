<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PrepareProjectCommand extends Command
{
    protected $signature = 'app:prepare';

    protected $description = 'Подготовка необходимых сущностей/данных';

    // TODO: Какая-та чанда с написанием месседжа в сообщении, разобраться
    public function handle(): void
    {
        $commands = [
            CreateAdminUserCommand::class
        ];

        /** @var Command $command */
        foreach ($commands as $command) {
            (new $command())->handle();
        }

        $this->info('Все команды успешно применены');
    }
}
