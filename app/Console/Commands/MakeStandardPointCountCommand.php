<?php

namespace App\Console\Commands;

use App\Condition\Conditioner;
use App\Models\TradeCountModel;
use Illuminate\Console\Command;

class MakeStandardPointCountCommand extends CommandBase
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:standard-point-count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make standard point count to tbl_trade_count table.';

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
        $this->errorTrap();

        try
        {
            self::$errorInfo = 0;

            $this->myEcho(' Start: Make standard point count to tbl_trade_count table.');

            $this->makeStandardPointCount();

//            $this->send(self::MAIL_TO, '[make:ranking] successful', '[make:ranking] cron was executed successfully');

            $this->myEcho(' End: Make standard point count to tbl_trade_count table.');

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

    protected function makeStandardPointCount()
    {
        $tradeCountModel = new TradeCountModel();
        $tradeCountModel->clearTable([Conditioner::SITE_NUMBER_GINATONIC]);

        $tradeCountModel->importStandardPointCount();
    }

    protected function sendErrorMessage(string $message)
    {
//        $this->send(self::MAIL_TO, '[make:cpta] failed', '[make:cpta] cron ended in failure\n' . $message);
    }

}
