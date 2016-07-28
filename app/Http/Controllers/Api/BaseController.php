<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Http\Response;

class BaseController extends Controller
{
    /**
     * @param string $message
     * @return \Illuminate\Http\Response
     */
    protected function respondWithSuccess($data, $message = '', $code = 200, $status = 'success')
    {
        return new Response(json_encode([
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ]));
    }

    /**
     * respond with all validation errors
     * @param  \Illuminate\Validation\Validator $validator the validator that failed to pass
     * @return \Illuminate\Http\Response the appropriate response containing the error message
     */
    protected function respondWithFailedValidation(\Illuminate\Validation\Validator $validator)
    {
        return $this->respondWithErrors($validator->messages()->first());
    }

    protected function respondWithErrors($message = '', $code = 404, $status = 'error')
    {
        return new Response(json_encode([
            'status' => $status,
            'code' => $code,
            'message' => $message,
        ]));
    }
}
