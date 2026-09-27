<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use function Laravel\Prompts\select;

#[Signature('dev:token {email? : O e-mail do utilizador}')]
#[Description('Gera um token do Sanctum para testes em ambiente de desenvolvimento')]
class GenerateDevAuthToken extends Command
{  
    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (! app()->environment(['local', 'testing'])) {
            $this->error('Este comando só pode ser executado em ambiente de desenvolvimento!');
            return Command::FAILURE;
        }

        $email = $this->argument('email');

        if (!$email) {
            $users = User::pluck('email')->toArray();

            if (empty($users)) {
                $this->error('Nenhum utilizador encontrado na base de dados.');
                return Command::FAILURE;
            }

            
            $email = select(
                label: 'Selecione o utilizador para gerar o token:',
                options: $users
            );
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("Utilizador com o e-mail '{$email}' não foi encontrado.");
            return Command::FAILURE;
        }

        $user->tokens()->where('name', 'dev-artisan-token')->delete();
        $token = $user->createToken('dev-artisan-token')->plainTextToken;

        $this->newLine();
        $this->info("TOKEN: <fg=yellow>{$token}</>");
        $this->newLine();

        return Command::SUCCESS;
    }
}
