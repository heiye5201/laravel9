<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:generate_admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成后台超级管理员账号';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // php artisan passport:client
        // 以及admins 用户表数据， 以及 oauth_clients 数据
        // name = admins; provider=admins ; password_client = 1
    }
}
