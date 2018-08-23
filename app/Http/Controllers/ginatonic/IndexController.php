<?php

namespace App\Http\Controllers\ginatonic;

use App\Decorators\CityListDecorator;
use App\Decorators\CityTradeDecorator;
use App\Decorators\ListDecorator;
use App\Decorators\PrefectureListDecorator;
use App\Decorators\PrefectureTradeDecorator;
use App\Decorators\StationTradeDecorator;
use App\Decorators\TownTradeDecorator;
use App\Decorators\TradeDecorator;
use App\Factories\AreaFactory;
use App\Factories\PostedLandPriceRankingFactory;
use App\Http\Controllers\Common\BaseController;
use App\Http\Controllers\Controller;
use App\Models\PostedLandPriceAverageModel;
use App\Models\TownMlitModel;
use Illuminate\Database\ConnectionInterface;
use \Illuminate\Support\Facades\Request;
use App\Value\AreaValue;

class IndexController extends BaseController
{
    //
    public function index(ConnectionInterface $conn)
    {
        $body = $this->indexImpl();

        $body['ranking'] = $this->ranking($this->areaValue);

        $body['breadcrumb'] = $this->breadcrumb($this->areaValue);

        return view('ginatonic/index', ['body' => $body]);
    }

    public function area(ConnectionInterface $conn, string $prefecture, string $city = null, int $townId = null)
    {
        $body = $this->areaImpl($prefecture, $city, $townId);

        $tradeDecorator = $this->tradeDecorator($this->areaValue);
        $body['figure'] = $tradeDecorator->figure();

        $body['tradeTable']['pageNum'] = $tradeDecorator->pageNum();
        $body['tradeTable']['recordsCount'] = $tradeDecorator->recordsCount();

        $body['breadcrumb'] = $this->breadcrumb($this->areaValue);

        return view('ginatonic/index', ['body' => $body]);
    }

    protected function ranking(AreaValue $areaValue): array
    {
        $factory = new PostedLandPriceRankingFactory($areaValue);

        $res['prefecture'] = $factory->product(PostedLandPriceRankingFactory::PREFECTURE_RANKING);
        $res['city'] = $factory->product(PostedLandPriceRankingFactory::CITY_RANKING_IN_JAPAN);

        return $res;
    }

    protected function breadcrumb(AreaValue $areaValue = null): array
    {
        if ($areaValue == null){
            $res[] = ['caption' => '地価公示価格・土地評価額がわかるサイト',
                        'link' => ''];
            return $res;
        }
        $res = $areaValue->breadcrumb('地価公示価格・土地評価額がわかるサイト');
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
        $res['title'] = "{$prefixOf}地価公示価格・土地評価額がわかるサイト";
        $res['keywords'] = "地価公示価格,{$prefix} 地価,{$prefix} 公示地価,{$prefix} 土地評価額,{$prefix} 土地評価,{$prefix} 土地価格";
        $res['description'] = "税金や公共事業用地取得時の基準となる地価公示価格がわかり、一般の土地取引の際の土地評価額の無料査定ができるサイトです。公示価格は国交省公表のデータが地域別で見やすくなっており、土地評価額は最大6社に一括で無料査定依頼ができ価格比較に最適です。";
        if ($prefix != ''){
            $res['description'] = "{$prefix}の地価公示価格がわかるサイトです。一般の土地取引の際の土地評価額も最大6社に一括で無料査定依頼ができ価格比較に最適です。公示価格は、国交省公表のデータを{$prefix}内の市区町村・町域・駅ごとにし、推移がわかるグラフやランキング比較も交えて掲載しています。";
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
        return "{$prefixOf}地価公示価格・{$prefixOf}土地評価額がわかるサイト";
    }

    protected function subject(): string
    {
        return "地価公示価格・土地評価額";
    }

    protected function catchCopy(AreaValue $areaValue = null): array
    {
        $prefixOf = '';
        if (isset($areaValue)){
            $displayName = $areaValue->displayName();
            $prefixOf = $displayName . 'の';
        }
        if (!isset($areaValue)){
            $prefixOf = '全国の';
        }
        $res[0] = "{$prefixOf}土地の評価額が知りたい方必見";
        $res[1] = "{$prefixOf}地価公示価格と売却価格がわかります！";
        $res[2] = "{$prefixOf}あなたの土地評価額(売却価格)はいくら？";
        $res[3] = "最短45秒で最大<span class='red'>6社</span>に<span class='red'>一括無料査定</span>";

        return $res;
    }

    protected function form(): array
    {
        $res = ['clientCount' => '1,400',
                'buttonValue' => '無料査定スタート'];
        return $res;
    }

    protected function formId(): string
    {
        // TODO:
        // 辻さんにフォーム ID 聞く！！
        return 'tsfol111souba_fudosan';
    }

}
