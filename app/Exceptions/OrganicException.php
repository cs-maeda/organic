<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/20
 * Time: 15:23
 */

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class OrganicException extends Handler
{
    protected function renderHttpException(HttpException $exception)
    {
        $body = [];
//        switch ($exception->getStatusCode()){
//            case 403:
//            case 404:
//            case 500:
//            default:
//
//        }


        return response()->view('errors/error', ['body' => $body]);
    }
}
