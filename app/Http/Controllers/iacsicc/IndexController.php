<?php

namespace App\Http\Controllers\Iacsicc;

use App\Decorators\CityListDecorator;
use App\Decorators\ListDecorator;
use App\Decorators\PrefectureListDecorator;
use App\Factories\AreaFactory;
use App\Http\Controllers\Common\BaseController;
use App\Http\Controllers\Controller;
use App\Models\TownMlitModel;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Http\Request;
use App\Value\AreaValue;

class IndexController extends BaseController
{
    //

    public function index(ConnectionInterface $conn)
    {
        $body = $this->indexImpl();

        return view('iacsicc/index', ['body' => $body]);
    }

    public function area(ConnectionInterface $conn, string $prefecture, string $city = null, int $townId = null)
    {
        $body = $this->areaImpl($prefecture, $city, $townId);

        return view('iacsicc/index', ['body' => $body]);
    }

    public function station(ConnectionInterface $conn, string $prefecture, string $city, int $stationId)
    {
        $body = $this->stationImpl($prefecture, $city, $stationId);

        return view('iacsicc/index', ['body' => $body]);
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
        $res['title'] = "{$prefixOf}不動産売買の相場がわかるサイト";
        $res['keywords'] = "不動産,{$prefix} 不動産価格,{$prefix} 不動産売買,国交省,土地総合情報システム";
        $res['description'] = "不動産価格・不動産売買の相場では、国交省の公開データを元に、実際に行われた取引における不動産価格を無料で公開しています。不動産価格に詳しく、不動産売買実績も豊富な不動産会社に、無料で査定依頼ができる窓口もあり、そちらも是非ご活用ください。";
        if ($prefix != ''){
            $res['description'] = "国交省が公開している{$prefix}の不動産売却実績における不動産価格を無料で公開しています。{$prefix}の不動産価格に詳しく、不動産売買実績も豊富な会社に無料で査定依頼ができる窓口もあり、そちらも是非ご活用ください。";
        }
        return $res;
    }

    protected function headLine(AreaValue $areaValue = null): string
    {
        $prefixOf = '';
        if (isset($areaValue)){
            $displayName = $areaValue->displayName();
            $prefixOf = $displayName . 'の';
        }
        return "{$prefixOf}不動産価格・不動産売買の相場";
    }

    protected function catchCopy(AreaValue $areaValue = null): array
    {
        $prefixOf = '';
        if (isset($areaValue)){
            $displayName = $areaValue->displayName();
            $prefixOf = $displayName . 'の';
        }
        $res[0] = $prefixOf . '不動産価格・不動産売買の相場がわかる！';
        $res[1] = $prefixOf . 'エリア別の不動産売買実績を無料で公開中！';
        $res[2] = $prefixOf . '不動産価格を知りたい方向けの、無料一括査定の窓口も！';
        $res[3] = $prefixOf . '1分以内の簡単入力で最大6社に一括査定依頼！';

        return $res;
    }

    protected function formId(): string
    {
        return 'tsfol111souba_fudosan';
    }
}
