<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AddSsoRoutesToWeb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add-route-to-web';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menambah Route ke web.php';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public $webRoute = '/routes/web.php';
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $webFilePath = base_path($this->webRoute);
        $content = file_get_contents($webFilePath);
        $content .= "\n" . 'require __DIR__."/sso_routes.php";';
        file_put_contents($webFilePath, $content);
    }
}
