<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2017/10/17
 * Time: 14:08
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

abstract class CommandBase extends Command
{
    static protected $errorInfo = 0;

    protected $isEcho = true;
    protected $isSend = true;

    const MAIL_TO = 'dev@lvn.co.jp';

    public function setEcho(bool $isEcho = true)
    {
        $this->isEcho = $isEcho;
    }

    public function setSend(bool $isSend = true)
    {
        $this->isSend = $isSend;
    }

    public function myEcho(string $message)
    {
        if (!$this->isEcho){
            return;
        }
        echo date('Y-m-d H:i:s') . $message . PHP_EOL;
        Log::info(date('Y-m-d H:i:s') . $message);
    }

    public function send(string $to, string $subject, string $message)
    {
        if (!$this->isSend){
            return;
        }
        Mail::raw($message, function($message) use($to, $subject)
        {
            $message->to($to)->subject($subject);
        });
    }

    public function errorTrap()
    {
        set_error_handler(function($errNo, $errStr, $errFile, $errLine){
            throw new \Exception($errStr);
        });

        register_shutdown_function(function () {
            if (self::$errorInfo == 0){
                $this->sendErrorMessage("Error caught register_shutdown_function().");
            }
        });
    }

    abstract protected function sendErrorMessage(string $message);

}
