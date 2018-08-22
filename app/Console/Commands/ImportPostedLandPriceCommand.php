<?php

namespace App\Console\Commands;

use App\Models\PostedLandPriceModel;
use Illuminate\Console\Command;

class ImportPostedLandPriceCommand extends CommandBase
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:posted-land-price {csv} {year}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import posted land price from csv to tbl_posted_land_price.';

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
        $csvFile = $this->argument('csv');
        $year = $this->argument('year');

        $this->errorTrap();

        try {
            self::$errorInfo = 0;

            $this->myEcho(' Start: Import posted land price from csv to tbl_posted_land_price.');

            $res = file_exists($csvFile);
            if ($res === false){
                throw new \Exception('Missing file!');
            }
            $this->import($csvFile, $year);

            $this->myEcho(" End: Import posted land price from csv to tbl_posted_land_price. [{$csvFile}] [{$year}]");

            self::$errorInfo = 1;
        } catch (\Throwable $e) {
            $this->myEcho($e->getTraceAsString());

            $this->sendErrorMessage($e->getTraceAsString());

            self::$errorInfo = 1;

            throw($e);
        }
    }

    protected function import(string $csvFile, int $year)
    {
        setLocale(LC_ALL, 'ja_JP');

        $fp = fopen($csvFile, 'r');
        $headers = fgetcsv($fp);
        mb_convert_variables('UTF-8', 'sjis-win', $headers);
        $columnNumbers = $this->columnNumber($headers, $year);

        while (($line = fgetcsv($fp)) !== false)
        {
            mb_convert_variables('UTF-8', 'sjis-win', $line);

            $model = new PostedLandPriceModel();

            $index = $columnNumbers['経度'];
            if ($index != -1){
                $model->longitude = $line[$index];
            }
            $index = $columnNumbers['緯度'];
            if ($index != -1){
                $model->latitude = $line[$index];
            }
            $index = $columnNumbers['所在地コード'];
            if ($index != -1){
                $model->city_id = $line[$index];
            }
            $index = $columnNumbers['用途'];
            if ($index != -1){
                $model->land_usage = $line[$index];
            }
            $index = $columnNumbers['年次'];
            if ($index != -1){
                $model->year = $line[$index];
            }
            $index = $columnNumbers['住居表示'];
            if ($index != -1){
                $model->address = str_replace('　', '', $line[$index]);
            }
            $index = $columnNumbers['地積'];
            if ($index != -1){
                $model->area = $line[$index];
            }
            $index = $columnNumbers['利用の現況'];
            if ($index != -1){
                $situation = $this->presentSituation($line[$index]);
                $model->present_situation = $situation;
            }
            $index = $columnNumbers['形状区分'];
            if ($index != -1){
                $model->shape = $line[$index];
            }
            $index = $columnNumbers['前面道路区分'];
            if ($index != -1){
                $model->road_situation = $line[$index];
            }
            $index = $columnNumbers['前面道路の方位区分'];
            if ($index != -1){
                $model->road_direction = $line[$index];
            }
            $index = $columnNumbers['前面道路の幅員'];
            if ($index != -1){
                $model->road_width = $line[$index];
            }
            $index = $columnNumbers['周辺の土地の利用の現況'];
            if ($index != -1){
                $model->peripheral_situation = $line[$index];
            }
            $index = $columnNumbers['駅名'];
            if ($index != -1){
                $model->station_name = $line[$index];
            }
            $index = $columnNumbers['駅距離'];
            if ($index != -1){
                $model->station_distance = $line[$index];
            }
            $index = $columnNumbers['用途区分'];
            if ($index != -1){
                $model->use_segment = $line[$index];
            }
            $index = $columnNumbers['都市計画区分'];
            if ($index != -1){
                $model->city_plan = $line[$index];
            }
            $index = $columnNumbers['建ぺい率'];
            if ($index != -1){
                $model->building_ratio = $line[$index];
            }
            $index = $columnNumbers['容積率'];
            if ($index != -1){
                $model->floor_ratio = $line[$index];
            }
            $index = $columnNumbers['価格'];
            if ($index != -1){
                $model->price = $line[$index];
            }
            $model->save();
            unset($model);

            echo '.';
        }
        echo PHP_EOL;
    }

    protected function presentSituation(string $situationCode): string
    {
        $items = ['住宅', '店舗', '事務所', '銀行', '旅館', '給油所', '工場', '倉庫', '農地', '山林', '医院', '空地', '作業場', '原野', 'その他', '用材', '雑木'];

        $situation = '';
        $values = str_split($situationCode);
        $index = 0;
        foreach ($values as $value){
            if ($value != '0'){
                return $items[$index];
                break;
            }
            $index++;
        }
    }

    protected function columnNumber(array $headers, int $year): array
    {
        $res = [];
        $res['経度'] = $this->searchColumn('経度', $headers);
        $res['緯度'] = $this->searchColumn('緯度', $headers);
        $res['所在地コード'] = $this->searchColumn('所在地コード', $headers);
        $res['用途'] = $this->searchColumn('用途', $headers);
        $res['年次'] = $this->searchColumn('年次', $headers);
        $res['住居表示'] = $this->searchColumn('住居表示', $headers);
        $res['地積'] = $this->searchColumn('地積', $headers);
        $res['利用の現況'] = $this->searchColumn('利用の現況', $headers);
        $res['形状区分'] = $this->searchColumn('形状区分', $headers);
        $res['前面道路区分'] = $this->searchColumn('前面道路区分', $headers);
        $res['前面道路の方位区分'] = $this->searchColumn('前面道路の方位区分', $headers);
        $res['前面道路の幅員'] = $this->searchColumn('前面道路の幅員', $headers);
        $res['周辺の土地の利用の現況'] = $this->searchColumn('周辺の土地の利用の現況', $headers);
        $res['駅名'] = $this->searchColumn('駅名', $headers);
        $res['駅距離'] = $this->searchColumn('駅距離', $headers);
        $res['用途区分'] = $this->searchColumn('用途区分', $headers);
        $res['都市計画区分'] = $this->searchColumn('都市計画区分', $headers);
        $res['建ぺい率'] = $this->searchColumn('建ぺい率', $headers);
        $res['容積率'] = $this->searchColumn('容積率', $headers);
        $res['価格'] = $this->searchColumn('価格', $headers, $year);

        return $res;
    }

    protected function searchColumn(string $key, array $headers, int $year = 0): int
    {
        if ($key == '価格'){
            $key = $this->translationYear($year);
        }

        $keyIndex = -1;
        $index = 0;
        foreach ($headers as $header)
        {
            if ($key == $header){
                $keyIndex = $index;
                break;
            }
            $index++;
        }
        return $keyIndex;
    }

    protected function translationYear(int $year): string
    {
        $waYear = $year - 1988;
        $res = 'Ｈ' . mb_convert_kana($waYear, 'N') . '価格';

        return $res;
    }

    protected function sendErrorMessage(string $message)
    {
//        $this->send(self::MAIL_TO, '[make:cpta] failed', '[make:cpta] cron ended in failure\n' . $message);
    }
}
