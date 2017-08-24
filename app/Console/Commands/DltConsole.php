<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;

class TestConsole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dlt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'dlt description.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       log::info('你好！这里是执行定时任务存在log文件里面');
    }
}
