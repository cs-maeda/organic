<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/20
 * Time: 15:33
 */

namespace App\Condition;

use App\Value\AreaValue;
use Illuminate\Support\Facades\Request;

class Conditioner
{
    static protected $instance = null;

    protected $areaValue = null;
    protected $siteNumber = null;
    protected $siteCaption = null;
    protected $siteUrl = null;
    protected $appendCondition = '';

    const TRADE_TYPE_LAND = 1;          // 宅地（土地）
    const TRADE_TYPE_LAND_AND_BLDG = 2; // 宅地（土地と建物）
    const TRADE_TYPE_USED_MANSION = 3;  // 中古マンション等
    const TRADE_TYPE_FOREST_LAND = 4;   // 林地
    const TRADE_TYPE_FARM_LAND = 5;     // 農地

    const SITE_NUMBER_IACSICC = 0;      // www.iacs-icc.org
    const SITE_NUMBER_RHSINC = 1;       // www.rhs-inc.com

    protected function __construct(AreaValue $areaValue, string $root = null)
    {
        $this->areaValue = $areaValue;

        if ($root === null){
            $root = Request::root();
        }
        $res = strpos($root, 'iacs-icc');   // www.iacs-icc.org
        if ($res !== false){
            $this->siteNumber = self::SITE_NUMBER_IACSICC;
            $this->siteCaption = '不動産価格・不動産売買の相場';
            $this->siteUrl = env('APP_IACS_ICC_URL');
        }
        $res = strpos($root, 'rhs-inc');    // www.rhs-inc.com
        if ($res !== false){
            $this->siteNumber = self::SITE_NUMBER_RHSINC;
            $this->siteCaption = '土地価格・土地売買の相場';
            $this->siteUrl = env('APP_RHS_INC_URL');
        }
    }

    static public function instance(AreaValue $areaValue, string $root = null): Conditioner
    {
        if (self::$instance == null){
            self::$instance = new Conditioner($areaValue, $root);
        }
        return self::$instance;
    }

    static public function destroy()
    {
        self::$instance = null;
    }

    public function setAppendCondition($condition)
    {
        $this->appendCondition = $condition;
    }

    public function siteCondition(array &$bindArray): string
    {
        $bindArray[] = $this->siteNumber;
        return " AND site_number = ? ";
    }

    public function siteNumber(): int
    {
        return $this->siteNumber;
    }

    public function siteCaption(): string
    {
        return $this->siteCaption;
    }

    public function pageCaption(): string
    {
        $caption = $this->areaValue->displayName();
        if ($caption !== ''){
            $caption .= 'の';
        }
        $caption .= $this->siteCaption();
        return $caption;
    }

    public function pageLink(): string
    {
        $link  = $this->siteUrl;
        $link .= $this->areaValue->linkAddress();

        return $link;
    }

    public function tradeTableCondition(array &$bindArray): string
    {
        throw new \Exception;
    }
}
