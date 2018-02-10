<?php
/**
 * Created by PhpStorm.
 * User: yilun
 * Date: 2018/1/27
 * Time: 17:01
 */

namespace app\lib\exception;


use think\exception\Handle;
use think\Log;
use think\Request;

class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;

    // 需要返回客户端当前请求的 URL 路径
    public function render(\Exception $exception)
    {
        if ($exception instanceof BaseException) {
            // 如果是自定义的异常
            $this->code = $exception->code;
            $this->msg = $exception->msg;
            $this->errorCode = $exception->errorCode;
        } else {
            if (config('app_debug')) {
                // return default error page
                return parent::render($exception);
            } else {
                $this->code = 500;
                $this->msg = '服务器内部错误, 不想告诉你';
                $this->errorCode = 999;
                $this->recordErrorLog($exception);
            }

        }
        $request = Request::instance();
        $result = [
            'msg' => $this->msg,
            'error_code' => $this->errorCode,
            'request_url' => $request->url(),
        ];
        return json($result, $this->code);
    }

    private function recordErrorLog(\Exception $e)
    {
        Log::init([
            'type' => 'File',
            'path' => LOG_PATH,
            'level' => ['error'],
        ]);
        Log::record($e->getMessage(), 'error');
    }
}