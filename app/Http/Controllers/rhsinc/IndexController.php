<?php

namespace App\Http\Controllers\rhsinc;

use App\Factories\TradeDecoratorFactory;
use App\Http\Controllers\Common\BaseController;
use App\Http\Controllers\Controller;
use App\Value\AreaValue;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    //
    const RHS_INC_COM = 1;

    public function index(ConnectionInterface $conn)
    {
        $body = $this->indexImpl();

        $body['breadcrumb'] = $this->breadcrumb($this->areaValue);

        return view('rhsinc/index', ['body' => $body]);
    }

    public function area(ConnectionInterface $conn, string $prefecture, string $city = null, int $townId = null)
    {
        $body = $this->areaImpl($prefecture, $city, $townId);

        $tradeDecorator = $this->tradeDecorator($this->areaValue);
        $body['figure'] = $tradeDecorator->figure();

        $body['tradeTable']['pageNum'] = $tradeDecorator->pageNum();
        $body['tradeTable']['recordsCount'] = $tradeDecorator->recordsCount();

        $body['breadcrumb'] = $this->breadcrumb($this->areaValue);

        return view('rhsinc/index', ['body' => $body]);
    }

    public function station(ConnectionInterface $conn, string $prefecture, string $city, int $stationId)
    {
        $body = $this->stationImpl($prefecture, $city, $stationId);

        $tradeDecorator = $this->tradeDecorator($this->areaValue);
        $body['figure'] = $tradeDecorator->figure();

        $body['tradeTable']['pageNum'] = $tradeDecorator->pageNum();
        $body['tradeTable']['recordsCount'] = $tradeDecorator->recordsCount();

        $body['breadcrumb'] = $this->breadcrumb($this->areaValue);

        return view('rhsinc/index', ['body' => $body]);
    }

    protected function breadcrumb(AreaValue $areaValue = null): array
    {
        if ($areaValue == null){
            $res[] = ['caption' => '土地価格・土地売買の相場',
                'link' => ''];
            return $res;
        }
        $res = $areaValue->breadcrumb('土地価格・土地売買の相場');
        return $res;
    }

    protected function meta(AreaValue $areaValue = null): array
    {
        $prefix = '';
        $prefixOf = '';
        if (isset($areaValue)){
            $displayName = $areaValue->displayName();
            $prefix = $displayName;
            $prefixOf = $displayName . 'の';
        }
        $res['title'] = "{$prefixOf}土地価格・土地売買の相場がわかるサイト";
        $res['keywords'] = "土地,{$prefix} 土地価格,{$prefix} 土地売買,国交省,土地総合情報システム";
        $res['description'] = "{$prefixOf}土地価格に詳しく、土地売買実績も豊富な不動産会社に、無料で査定依頼ができる窓口もあり、そちらも是非ご活用ください。";

        return $res;
    }

    protected function headLine(AreaValue $areaValue = null): string
    {
        $prefixOf = '';
        if (isset($areaValue)){
            $displayName = $areaValue->displayName();
            $prefixOf = $displayName . 'の';
        }
        return "{$prefixOf}土地価格・土地売買の相場";
    }

    protected function catchCopy(AreaValue $areaValue = null): array
    {
        $prefixOf = '';
        if (isset($areaValue)){
            $displayName = $areaValue->displayName();
            $prefixOf = $displayName . 'の';
        }
        $res[0] = $prefixOf . '土地価格・土地売買の相場がわかる！';
        $res[1] = $prefixOf . 'エリア別の土地売買実績を無料で公開中！';
        $res[2] = $prefixOf . '土地価格を知りたい方向けの、無料一括査定の窓口も！';
        $res[3] = $prefixOf . '1分以内の簡単入力で最大6社に一括査定依頼！';

        return $res;
    }

    protected function formId(): string
    {
        return 'tsfol111souba_tochi';
    }

}
