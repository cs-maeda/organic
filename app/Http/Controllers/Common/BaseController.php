<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/12
 * Time: 9:03
 */

namespace App\Http\Controllers\Common;

use App\Decorators\CityListDecorator;
use App\Decorators\ListDecorator;
use App\Decorators\PrefectureListDecorator;
use App\Factories\AreaFactory;
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
        $body['meta'] = $this->meta();
        $body['headLine'] = $this->headLine();
        $body['form'] = $this->form();
        $body['copy'] = $this->catchCopy();
        $body['formId'] = $this->formId();
        $body['areaLink'] = $this->areaList();
        $body['where'] = 'index';
        $body['areaCaption'] = '';
        $body['areaCaptionOf'] = '';

        return $body;
    }

    public function areaImpl(string $prefecture, string $city = null, int $townId = null)
    {
        $body = [];

        $areaFactory = new AreaFactory($prefecture, $city, $townId);
        $this->areaValue = $areaFactory->product();

        $body['meta'] = $this->meta($this->areaValue);
        $body['headLine'] = $this->headLine($this->areaValue);
        $body['form'] = $this->form();
        $body['copy'] = $this->catchCopy($this->areaValue);
        $body['formId'] = $this->formId();
        $body['areaLink'] = $this->areaList($this->areaValue);
        $body['where'] = $this->areaValue->where();
        $body['prefectureId'] = $this->areaValue->prefectureId();
        $body['cityId'] = $this->areaValue->cityId();
        $body['townId'] = $this->areaValue->townId();
        $body['stationId'] = 0;
        $body['areaCaption'] = $this->areaValue->displayName();
        $body['areaCaptionOf'] = $body['areaCaption'] . 'の';
        $body['parentAreaCaption'] = $this->areaValue->parentAreaName();

        return $body;
    }

    public function stationImpl(string $prefecture, string $city, int $stationId)
    {
        $body = [];

        $areaFactory = new AreaFactory($prefecture, $city, $stationId, true);
        $this->areaValue = $areaFactory->product();

        $body['meta'] = $this->meta($this->areaValue);
        $body['headLine'] = $this->headLine($this->areaValue);
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
                $listDecorator = new PrefectureListDecorator();
                $res = $listDecorator->cityList($prefectureId);
                break;
            case 'city':
            case 'town':
            case 'station':
                $cityId = $areaValue->cityId();
                $listDecorator = new CityListDecorator();
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

    /*
     * META 情報を返す.
     */
    abstract protected function meta(AreaValue $areaValue = null): array;
    /*
     * Head line を返す.
     */
    abstract protected function headLine(AreaValue $areaValue = null): string ;
    /**
     * Catch copy を返す.
     */
    abstract protected function catchCopy(AreaValue $areaValue = null): array;
    /*
     * FormId を返す.
     */
    abstract protected function formId(): string;
}
