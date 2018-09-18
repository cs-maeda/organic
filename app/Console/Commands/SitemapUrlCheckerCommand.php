<?php

namespace App\Console\Commands;

use App\Models\SitemapUrlModel;
use Illuminate\Console\Command;

class SitemapUrlCheckerCommand extends CommandBase
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:sitemap_url {creatorId}';

	protected $creatorId = null;
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
		// 引数取得
		$this->creatorId = $this->argument('creatorId');

		$this->errorTrap();

		try {
			self::$errorInfo = 0;

			$this->myEcho(' Start: Check sitemap_url.');

			$this->urlCheck();

			$this->send(self::MAIL_TO,
				"[check:sitemap_url] {$this->creatorId}) successful",
				'[check:sitemap_url] cron was executed successfully');

			$this->myEcho(' End: Check sitemap_url.');

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

	/**
	 * @throws \Exception
	 */
	protected function urlCheck()
	{
		$ngItem = array();

		// サイトマップURLを取得
		foreach (SitemapUrlModel::where('creator_id', $this->creatorId)
					 ->orderBy('url_id')
					 ->cursor() as $result)
		{
			$urlList[$result['url_id']] = $result['url'];
		}

		// 404チェック
		$context = stream_context_create(
			array(
				// HTTPステータス4xx, 5xxなどでWarnningエラーが出ないように設定
				'http' => array('ignore_errors' => true),
				// 無効な証明書でWarnningエラーが出ないよう設定
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
				),
			)
		);
		foreach ($urlList as $urlId => $url) {
			// 試行回数の初期化
			$errCnt = 0;
			// 最大試行回数
			$maxTries = 3;
			while (true) {
				try {
					$res = @file_get_contents($url, false, $context);
					// HTTPステータスが200以外の場合はNGフラグ
					$pos = strpos($http_response_header[0], '200');
					if ($pos === false) {
						$ngItem[] = $urlId;
					}
					break;
				} catch (\Exception $e) {
					sleep(1);
					if (++$errCnt === $maxTries) {
						// 最大試行回数になった場合、HTTPステータスを取得する処理を飛ばす
						break;
					}
				}
			}
		}

		// SQL実行
		if (count($ngItem) === 0) {
			// creatorIdと一致するレコードのNGフラグを全て0に設定
			SitemapUrlModel::where('creator_id', $this->creatorId)
				->update(['ng_flag' => 0]);
		} else {
			// creatorIdと一致し、200以外が返ってきたレコードのNGフラグを全て1に設定
			SitemapUrlModel::where('creator_id', $this->creatorId)
				->whereIn('url_id', $ngItem)
				->update(['ng_flag' => 1]);
			// creatorIdと一致し、200が返ってきたレコードのNGフラグを全て0に設定
			SitemapUrlModel::where('creator_id', $this->creatorId)
				->whereNotIn('url_id', $ngItem)
				->update(['ng_flag' => 0]);
		}
	}

	protected function sendErrorMessage(string $message)
	{
		$this->send(self::MAIL_TO,
			"[check:sitemap_url] {$this->creatorId} failed",
			'[check:sitemap_url] cron ended in failure\n' . $message);
	}
}
