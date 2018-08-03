<?php

namespace App\Exceptions;

use App\Condition\PrefectureConditioner;
use App\Value\AreaValue;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }

    protected function renderHttpException(HttpException $e)
    {
        $status = $e->getStatusCode();

        $root = Request::root();

        $body['siteName'] = '';
        $body['css'] = '';
        $res = strpos($root, 'iacs-icc');   // www.iacs-icc.org
        if ($res !== false){
            $body['headLine'] = '不動産価格・不動産売買の相場';
            $body['folder'] = 'iacsicc';
        }
        $res = strpos($root, 'rhs-inc');    // www.rhs-inc.com
        if ($res !== false){
            $body['headLine'] = '土地価格・土地売買の相場';
            $body['folder'] = 'rhsinc';
        }
        return response()->view("errors.common", ['body' => $body], $status);
    }


}
