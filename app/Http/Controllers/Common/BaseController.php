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
    public function indexImpl()
    {
        $body = [];
        $body['meta'] = $this->meta();
        $body['headLine'] = $this->headLine();
        $body['copy'] = $this->catchCopy();
        $body['list'] = $this->areaList();
        $body['where'] = 'index';

        return $body;
    }

    public function areaImpl(string $prefecture, string $city = null, int $townId = null)
    {
        $body = [];

        $areaFactory = new AreaFactory($prefecture, $city, $townId);
        $areaValue = $areaFactory->product();

        $body['meta'] = $this->meta($areaValue);
        $body['headLine'] = $this->headLine($areaValue);
        $body['copy'] = $this->catchCopy();
        $body['list'] = $this->areaList($areaValue);
        $body['where'] = $areaValue->where();

        return $body;
    }

    public function stationImpl(string $prefecture, string $city, int $stationId)
    {
        $body = [];

        $areaFactory = new AreaFactory($prefecture, $city, $stationId, true);
        $areaValue = $areaFactory->product();

        $body['meta'] = $this->meta($areaValue);
        $body['headLine'] = $this->headLine($areaValue);
        $body['copy'] = $this->catchCopy();
        $body['list'] = $this->areaList($areaValue);
        $body['where'] = $areaValue->where();

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
