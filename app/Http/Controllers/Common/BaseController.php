<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/12
 * Time: 9:03
 */

namespace App\Http\Controllers\Common;

use App\Decorators\CityListDecorator;
use App\Decorators\CityTradeDecorator;
use App\Decorators\ListDecorator;
use App\Decorators\PrefectureListDecorator;
use App\Decorators\PrefectureTradeDecorator;
use App\Decorators\StationTradeDecorator;
use App\Decorators\TownTradeDecorator;
use App\Decorators\TradeDecorator;
use App\Factories\AreaFactory;
use App\Factories\EachLinkFactory;
use App\Http\Controllers\Controller;
use App\Models\TownMlitModel;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Http\Request;
use App\Value\AreaValue;

abstract class BaseController extends Controller
{
    protected $areaValue = null;

    public function indexImpl()
    {
        $body = [];

        $areaFactory = new AreaFactory();
        $this->areaValue = $areaFactory->product();

        $body['meta'] = $this->meta();
        $body['headLine'] = $this->headLine();
        $body['subject'] = $this->subject();
        $body['form'] = $this->form();
        $body['copy'] = $this->catchCopy();
        $body['formId'] = $this->formId();
        $body['areaLink'] = $this->areaList();
        $body['where'] = 'index';
        $body['prefectureId'] = '';
        $body['prefectureAlphabet'] = '';
        $body['cityId'] = '';
        $body['cityAlphabet'] = '';
        $body['townId'] = '';
        $body['areaCaption'] = '';
        $body['areaCaptionOf'] = '';

        $eachLink = new EachLinkFactory($this->areaValue);
        $body['eachLink'] = $eachLink->product();

        return $body;
    }

    public function areaImpl(string $prefecture, string $city = null, int $townId = null)
    {
        $body = [];

        $areaFactory = new AreaFactory($prefecture, $city, $townId);
        $this->areaValue = $areaFactory->product();

        $body['meta'] = $this->meta($this->areaValue);
        $body['headLine'] = $this->headLine($this->areaValue);
        $body['subject'] = $this->subject();
        $body['form'] = $this->form();
        $body['copy'] = $this->catchCopy($this->areaValue);
        $body['formId'] = $this->formId();
        $body['areaLink'] = $this->areaList($this->areaValue);
        $body['where'] = $this->areaValue->where();
        $body['prefectureId'] = $this->areaValue->prefectureId();
        $body['prefectureAlphabet'] = $this->areaValue->prefectureAlphabet();
        $body['cityId'] = $this->areaValue->cityId();
        $body['cityAlphabet'] = $this->areaValue->cityAlphabet();
        $body['townId'] = $this->areaValue->townId();
        $body['stationId'] = 0;
        $body['areaCaption'] = $this->areaValue->displayName();
        $body['areaCaptionOf'] = $body['areaCaption'] . 'の';
        $body['parentAreaCaption'] = $this->areaValue->parentAreaName();

        $eachLink = new EachLinkFactory($this->areaValue);
        $body['eachLink'] = $eachLink->product();

        return $body;
    }

    public function stationImpl(string $prefecture, string $city, int $stationId)
    {
        $body = [];

        $areaFactory = new AreaFactory($prefecture, $city, $stationId, true);
        $this->areaValue = $areaFactory->product();

        $body['meta'] = $this->meta($this->areaValue);
        $body['headLine'] = $this->headLine($this->areaValue);
        $body['subject'] = $this->subject();
        $body['form'] = $this->form();
        $body['copy'] = $this->catchCopy($this->areaValue);
        $body['formId'] = $this->formId();
        $body['areaLink'] = $this->areaList($this->areaValue);
        $body['where'] = $this->areaValue->where();
        $body['prefectureId'] = $this->areaValue->prefectureId();
        $body['cityId'] = $this->areaValue->cityId();
        $body['townId'] = 0;
        $body['stationId'] = $this->areaValue->stationId();
        $body['areaCaption'] = $this->areaValue->displayName();
        $body['areaCaptionOf'] = $this->areaValue->displayName() . 'の';
        $body['parentAreaCaption'] = $this->areaValue->parentAreaName();

        $eachLink = new EachLinkFactory($this->areaValue);
        $body['eachLink'] = $eachLink->product();

        return $body;
    }

    protected function areaList(AreaValue $areaValue = null): array
    {
        $res = [];
        if (! isset($areaValue)){
            $listDecorator = new ListDecorator();
            $res = $listDecorator->prefectureList();
            return $res;
        }
        $where = $areaValue->where();
        switch ($where){
            case 'prefecture':
                $prefectureId = $areaValue->prefectureId();
                $listDecorator = new PrefectureListDecorator($areaValue);
                $res = $listDecorator->cityList($prefectureId);
                break;
            case 'city':
            case 'town':
            case 'station':
                $cityId = $areaValue->cityId();
                $listDecorator = new CityListDecorator($areaValue);
                $res = $listDecorator->townStationList($cityId);
                break;
            default:
                break;
        }

        return $res;
    }

    protected function form(): array
    {
        $res = ['clientCount' => '1,400',
                'buttonValue' => '最短45秒無料査定!'];
        return $res;
    }

    protected function tradeDecorator(AreaValue $areaValue): TradeDecorator
    {
        $tradeDecorator = null;

        $where = $areaValue->where();
        switch($where)
        {
            case 'prefecture':
                $tradeDecorator = new PrefectureTradeDecorator($areaValue);
                break;
            case 'city':
                $tradeDecorator = new CityTradeDecorator($areaValue);
                break;
            case 'town':
                $tradeDecorator = new TownTradeDecorator($areaValue);
                break;
            case 'station':
                $tradeDecorator = new StationTradeDecorator($areaValue);
                break;
            default:
                break;
        }
        return $tradeDecorator;
    }

    /*
     * META 情報を返す.
     */
    abstract protected function meta(AreaValue $areaValue = null): array;
    /*
     * Head line を返す.
     */
    abstract protected function headLine(AreaValue $areaValue = null): string ;
    /*
     * subject を返す.
     */
    abstract protected function subject(): string;
    /**
     * Catch copy を返す.
     */
    abstract protected function catchCopy(AreaValue $areaValue = null): array;
    /*
     * FormId を返す.
     */
    abstract protected function formId(): string;
}
