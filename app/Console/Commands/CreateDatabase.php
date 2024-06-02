<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class CreateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建数据库，并执行迁移数据库文件';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $databaseName = env('DB_DATABASE', 'forge');
        // 使用原生 SQL 命令创建数据库
        config(['database.connections.mysql.database' => null]);
        Schema::connection('mysql')->createDatabase($databaseName);
        $this->info('Database ' . $databaseName . ' created successfully!');
        // 切换到新创建的数据库
        DB::purge('mysql');
        config(['database.connections.mysql.database' => $databaseName]);
        // 重新建立数据库连接
        DB::reconnect('mysql');
        // 运行数据库迁移命令
        try {
            Artisan::call('migrate');
            $this->info('Migrations executed successfully.');
        } catch (\Exception $e) {
            $this->error('Error running migrations: ' . $e->getMessage());
        }
    }
}
