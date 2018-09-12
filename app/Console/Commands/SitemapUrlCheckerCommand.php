<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SitemapUrlCheckerCommand extends CommandBase
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:sitemap_url';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sitemap URL checker.';

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
        //
    }

    protected function sendErrorMessage(string $message)
    {
    }
}
