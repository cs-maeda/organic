<?php

namespace App\Console\Commands;

use App\Models\SitemapCreatorModel;
use Illuminate\Console\Command;

class MakeSitemapCommand extends CommandBase
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:sitemap {creatorId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make sitemap.xml files.';

    protected $creatorId = null;
    protected $creatorInfo = [];

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
     */
    public function handle()
    {
        //
        $this->creatorId = $this->argument('creatorId');
        $this->creatorInfo = $this->creator($this->creatorId);

        $this->errorTrap();

        try {
            self::$errorInfo = 0;

            $this->myEcho(' Start: Make tbl_trade_ranking table.');

//            $this->makeRanking();

            $this->send(self::MAIL_TO,
                "[make:sitemap] {$this->creatorInfo['name']}({$this->creatorInfo['server']}) successful",
                '[make:sitemap] cron was executed successfully');

            $this->myEcho(' End: Make tbl_trade_ranking table.');

            self::$errorInfo = 1;
        }
        catch (\Throwable $e)
        {
            $this->myEcho($e->getTraceAsString());

            $this->sendErrorMessage($e->getTraceAsString());

            self::$errorInfo = 1;

            throw($e);
        }
    }

    protected function creator(int $creatorId): array
    {
        $res = [];
        $result = SitemapCreatorModel::where('creator_id', $creatorId)->first();
        $res['name'] = $result['name'];
        $res['server'] = $result['server'];

        return $res;
    }

    protected function sendErrorMessage(string $message)
    {
        $this->send(self::MAIL_TO,
            "[make:sitemap] {$this->creatorInfo['name']}({$this->creatorInfo['server']}) failed",
            '[make:sitemap] cron ended in failure\n' . $message);
    }
}
