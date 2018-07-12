<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/12
 * Time: 12:02
 */

namespace Cstyle;

use App\Decorators\FormResponser;

const API_HTTP_TIMEOUT = 5;

main();
exit;

/**
 * function main
 */
function main()
{
    $context = stream_context_create( array( 'http' => array('timeout' => API_HTTP_TIMEOUT ) ) );

    switch ($_GET['get']) {
        case 'city' :
        case 'allcity' :
        case 'town' :
        case 'alltown' :
        case 'allblock' :

            // 検索対象の値を引くための準備
            $prefecture = isset($_GET['prefecture']) ? $_GET['prefecture'] : '';
            $city       = isset($_GET['city'])       ? $_GET['city']       : '';
            $town       = isset($_GET['town'])       ? $_GET['town']       : '';

            $addressCode = array(
                'city'     => $prefecture,
                'allcity'  => $prefecture,
                'town'     => $city,
                'alltown'  => $city,
                'block'    => $town,
                'allblock' => $town,
            );

            $formResponser = new FormResponser();
            // 表示
            header('Content-Type: text/javascript');
            print $formResponser->getJsonp($_GET['callback'], $_GET['get'], $addressCode[$_GET['get']]);

            break;
        default :
            print '';
            break;
    }
}
