<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Http\Response;

class BaseController extends Controller
{
    /**
     * 响应成功
     * @param string $message
     * @return \Illuminate\Http\Response
     */
    protected function respondWithSuccess($data, $message = '', $code = 200, $status = 'success')
    {
        return new Response(json_encode([
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'result' => $data,
        ]));
    }

    /**
     * 响应所有的validation验证错误
     * @param  \Illuminate\Validation\Validator $validator the validator that failed to pass
     * @return \Illuminate\Http\Response the appropriate response containing the error message
     */
    protected function respondWithFailedValidation(\Illuminate\Validation\Validator $validator)
    {
        // 只取出一条错误信息
        return $this->respondWithErrors($validator->messages()->first(), 400);
    }
    
    /**
     * 响应错误
     * @param string $message
     * @param int $code
     * @param string $status
     * @return Response
     */
    protected function respondWithErrors($message = '', $code = 404, $status = 'error')
    {
        return new Response(json_encode([
            'status' => $status,
            'code' => $code,
            'message' => $message,
        ]));
    }
}
