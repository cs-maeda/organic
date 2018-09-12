<?php

namespace App\Console\Commands;

use App\Helper\XmlSitemapHelper;
use App\Models\SitemapCreatorModel;
use App\Models\SitemapUrlModel;
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

    const WRITE_LIMIT_COUNT = 50000;
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

            $this->generate();

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

    protected function storagePath(): string
    {
        $res = storage_path('app/public/sitemap/');
        if (env('APP_ENV') !== 'local') {
            $res = env('SITEMAP_STORAGE_PATH');
        }

        $domains = explode('.', $this->creatorInfo['server']);
        $res .= $domains[1];

        if (file_exists($res) === false) {
            mkdir($res, 0777, true);
        }
        $res .= '/';
        return $res;
    }

    protected function xmlFilePath(int $number): string
    {
        $path = $this->storagePath();
        $xmlFileNameFormat = "sitemap_%d.xml";

        $xmlFileName = sprintf($xmlFileNameFormat, $number);
        $filePath = $path . $xmlFileName;

        return $filePath;
    }

    protected function generate()
    {
        $writeCounter = 0;
        $fileNumber = 0;

        $xmlFilePath = $this->xmlFilePath($fileNumber);
        $xmlHelper = new XmlSitemapHelper($xmlFilePath);
        $xmlHelper->writeHeader();

        foreach (SitemapUrlModel::where('creator_id', $this->creatorId)
                    ->where('ng_flag', 0)
                    ->orderBy('url_id')
                    ->cursor() as $result)
        {
            $xmlHelper->writeContents($result['url']);

            $writeCounter++;
            if ($writeCounter >= self::WRITE_LIMIT_COUNT) {
                $fileNumber++;
                $xmlHelper->writeFooter();
                unset($xmlHelper);

                $xmlFilePath = $this->xmlFilePath($fileNumber);
                $xmlHelper = new XmlSitemapHelper($xmlFilePath);
                $writeCounter = 0;
            }
        }

        $xmlHelper->writeFooter();
        unset($xmlHelper);
    }

    protected function sendErrorMessage(string $message)
    {
        $this->send(self::MAIL_TO,
            "[make:sitemap] {$this->creatorInfo['name']}({$this->creatorInfo['server']}) failed",
            '[make:sitemap] cron ended in failure\n' . $message);
    }
}
