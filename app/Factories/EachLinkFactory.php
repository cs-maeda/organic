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
        if ($siteNumber !== Conditioner::SITE_NUMBER_GINATONIC){
            $otherSiteConditioner = $this->otherSiteConditioner(env('APP_GINATONIC_URL'));
            $res = $this->existLink($otherSiteConditioner, Conditioner::SITE_NUMBER_GINATONIC, $link);
            if ($res === true){
                $links[] = $link;
            }
        }
        // www.shopa.org
        $res = $this->shopaExistLink($link);
        if ($res === true){
            $links[] = $link;
        }

        Conditioner::destroy();
        return $links;
    }

    public function existLink(Conditioner $conditioner, int $siteNumber, &$link): bool
    {
        $where = $this->areaValue->where();
        if (($where == 'top')||($where == 'prefecture')){
            $link['caption'] = $conditioner->pageCaption();
            $link['link'] = $conditioner->pageLink();
            return true;
        }
        $area = $this->areaValue->currentId();

        $result = TradeCountModel::where('site_number', $siteNumber)
            ->where('area_id', $area['areaId'])
            ->where('station', $area['station'])
            ->count();

        if ($result <= 0){
            return false;
        }
        $link['caption'] = $conditioner->pageCaption();
        $link['link'] = $conditioner->pageLink();
        return true;
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

    protected function shopaExistLink(&$link): bool
    {
        $domain = $this->shopaDomain();
        $url = $domain . 'api' . $this->areaValue->linkAddress();
        $options =
            [
                'http' => [
                    'method' => 'GET',
                    'header' => 'User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)',
                    'ignore_errors' => true
                ],
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ]
            ];
        $json = @file_get_contents($url, false, stream_context_create($options));
        $results = json_decode($json);

        $link = [];
        if ($results->shopa === false){
            return false;
        }
        $title = '不動産相続・土地相続ガイド';
        if ($this->areaValue->where() != 'top'){
            $title = $this->areaValue->displayName() . '不動産相続・土地相続ガイド';
        }
        $link['caption'] = $title;
        $link['link'] = $results->shopa_link;

        return true;
    }

    protected function shopaDomain(): string
    {
        $domain = '';
        switch (env('APP_ENV')){
            case 'local':
                $domain = 'http://www.shopa.dev/';
                break;
            case 'staging':
                $domain = 'http://stg.shopa.org/';
                break;
            case 'production':
            default:
                $domain = 'http://www.shopa.org/';
                break;
        }
        return $domain;
    }

}
