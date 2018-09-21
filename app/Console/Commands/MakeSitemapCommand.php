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
     * @throws \Throwable
     */
    public function handle()
    {
        //
        $creatorId = $this->argument('creatorId');
        $this->creatorInfo = $this->creator($creatorId);

        $this->errorTrap();

        try {
            self::$errorInfo = 0;

            $this->myEcho(' Start: Make tbl_trade_ranking table.');

            $this->generate($creatorId);

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

        $res .= $this->domainName();

        if (file_exists($res) === false) {
            mkdir($res, 0777, true);
        }
        $res .= '/';
        return $res;
    }

    protected function domainName(): string
    {
        $domains = explode('.', $this->creatorInfo['server']);
        return $domains[1];
    }

    protected function xmlFilePath(int $number): string
    {
        $path = $this->storagePath();
        $xmlFileNameFormat = "sitemap_%d.xml";

        $xmlFileName = sprintf($xmlFileNameFormat, $number);
        $filePath = $path . $xmlFileName;

        return $filePath;
    }

    /**
     * @param int $creatorId
     * @throws \Exception
     */
    protected function generate(int $creatorId)
    {
        $fileNames = [];
        $writeCounter = 0;
        $fileNumber = 0;

        $xmlFilePath = $this->xmlFilePath($fileNumber);
        $parts = pathinfo($xmlFilePath);
        $fileNames[] = $parts['basename'];
        $xmlHelper = new XmlSitemapHelper($xmlFilePath);
        $xmlHelper->writeHeader();

        foreach (SitemapUrlModel::where('creator_id', $creatorId)
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
                $parts = pathinfo($xmlFilePath);
                $fileNames[] = $parts['basename'];
                $xmlHelper = new XmlSitemapHelper($xmlFilePath);
                $xmlHelper->writeHeader();
                $writeCounter = 0;
            }
        }

        $xmlHelper->writeFooter();
        unset($xmlHelper);

        $this->generateParentXmlFile($fileNames);
    }

    /**
     * @param array $files
     * @throws \Exception
     */
    protected function generateParentXmlFile(array $files)
    {
        $filePath = $this->storagePath();
        $filePath .= 'sitemap.xml';
        $xmlHelper = new XmlSitemapHelper($filePath);
        $xmlHelper->writeParentHeader();
        $domain = $this->domainName();

        foreach ($files as $file){
            $xmlHelper->writeParentContents('https://www.sumaistar.com/sitemaps/' . $domain . '/' . $file);
        }

        $xmlHelper->writeParentFooter();
        unset($xmlHelper);
    }

    protected function sendErrorMessage(string $message)
    {
        $this->send(self::MAIL_TO,
            "[make:sitemap] {$this->creatorInfo['name']}({$this->creatorInfo['server']}) failed",
            '[make:sitemap] cron ended in failure\n' . $message);
    }
}
