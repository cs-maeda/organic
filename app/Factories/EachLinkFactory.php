<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/08/02
 * Time: 16:47
 */

namespace App\Factories;


use App\Condition\CityConditioner;
use App\Condition\Conditioner;
use App\Condition\PrefectureConditioner;
use App\Condition\TownConditioner;
use App\Condition\StationConditioner;
use App\Http\Controllers\ApiController;
use App\Models\TradeCountModel;
use App\Value\AreaValue;
use App\Value\EachLinkValue;
use Illuminate\Support\Collection;

class EachLinkFactory
{
    protected $areaValue = null;

    public function __construct(AreaValue $areaValue = null)
    {
        $this->areaValue = $areaValue;
    }

    public function product(): array
    {
        $links = [];

        $conditioner = $this->conditioner();
        $siteNumber = $conditioner->siteNumber();

        if ($siteNumber !== Conditioner::SITE_NUMBER_IACSICC){
            $otherSiteConditioner = $this->otherSiteConditioner(env('APP_IACS_ICC_URL'));
            $res = $this->existLink($otherSiteConditioner, Conditioner::SITE_NUMBER_IACSICC, $link);
            if ($res === true){
                $links[] = $link;
            }
        }
        if ($siteNumber !== Conditioner::SITE_NUMBER_RHSINC){
            $otherSiteConditioner = $this->otherSiteConditioner(env('APP_RHS_INC_URL'));
            $res = $this->existLink($otherSiteConditioner, Conditioner::SITE_NUMBER_RHSINC, $link);
            if ($res === true){
                $links[] = $link;
            }
        }
        Conditioner::destroy();
        return $links;
    }

    protected function conditioner(): Conditioner
    {
        Conditioner::destroy();

        $factory = new ConditionerFactory($this->areaValue);
        $conditioner = $factory->product();

        return $conditioner;
    }

    protected function otherSiteConditioner(string $root): Conditioner
    {
        Conditioner::destroy();

        $factory = new ConditionerFactory($this->areaValue, $root);
        $conditioner = $factory->product();

        return $conditioner;
    }

    protected function existLink(Conditioner $conditioner, int $siteNumber, &$link): bool
    {
        $where = $this->areaValue->where();
        if ($where == 'top'){
            $link['caption'] = $conditioner->pageCaption();
            $link['link'] = $conditioner->pageLink();
            return true;
        }
        $area = $this->areaValue->currentId();

        $result = TradeCountModel::where('site_number', $siteNumber)
                                ->where('area_id', $area['areaId'])
                                ->where('station', $area['station'])
                                ->get();

        if ($result === false){
            return false;
        }

        $link['caption'] = $conditioner->pageCaption();
        $link['link'] = $conditioner->pageLink();
        return true;
    }

}
