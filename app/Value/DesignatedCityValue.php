<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/08/22
 * Time: 16:14
 */

namespace App\Value;


class DesignatedCityValue
{
    protected $designatedCities =
        [
            1101, 1102, 1103, 1104, 1105, 1106, 1107, 1108, 1109, 1110,
            4101, 4102, 4103, 4104, 4105,
            11101, 11102, 11103, 11104, 11105, 11106, 11107, 11108, 11109, 11110,
            12101, 12102, 12103, 12104, 12105, 12106,
            14101, 14102, 14103, 14104, 14105, 14106, 14107, 14108, 14109, 14110, 14111, 14112, 14113, 14114, 14115, 14116, 14117, 14118,
            14131, 14132, 14133, 14134, 14135, 14136, 14137,
            14151, 14152, 14153,
            15101, 15102, 15103, 15104, 15105, 15106, 15107, 15108,
            22101, 22102, 22103,
            22131, 22132, 22133, 22134, 22135, 22136, 22137,
            23101, 23102, 23103, 23104, 23105, 23106, 23107, 23108, 23109, 23110, 23111, 23112, 23113, 23114, 23115, 23116,
            26101, 26102, 26103, 26104, 26105, 26106, 26107, 26108, 26109, 26110, 26111,
            27102, 27103, 27104, 27106, 27107, 27108, 27109, 27111, 27113, 27114, 27115, 27116, 27117, 27118, 27119, 27120, 27121, 27122, 27123, 27124, 27125, 27126, 27127, 27128,
            27141, 27142, 27143, 27144, 27145, 27146, 27147,
            28101, 28102, 28105, 28106, 28107, 28108, 28109, 28110, 28111,
            33101, 33102, 33103, 33104,
            34101, 34102, 34103, 34104, 34105, 34106, 34107, 34108,
            40101, 40103, 40105, 40106, 40107, 40108, 40109,
            40131, 40132, 40133, 40134, 40135, 40136, 40137,
            43101, 43102, 43103, 43104, 43105, 43201,
        ];

    public function isDesignatedCity(int $cityId): bool
    {
        $res = in_array($cityId, $this->designatedCities);

        return $res;
    }

}
