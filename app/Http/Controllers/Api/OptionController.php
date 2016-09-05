<?php

namespace App\Http\Controllers\Api;

use App\Http\Model\Option;
use Illuminate\Http\Request;

use App\Http\Requests;

class OptionController extends BaseController
{
    /**
     * @api {get} /getPlayNode.api 获取播放节点
     * @apiDescription  获取播放节点
     * @apiGroup Option
     * @apiPermission none
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "获取播放节点成功",
     *           "result": {
     *               "node": "app"
     *           }
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 400,
     *           "message": "获取播放节点失败"
     *      }
     */
    public function getPlayNode()
    {
        $option = Option::where('name', 'play_node')->first();
        if (isset($option)) {
            $result = [
                'node' => $option->content
            ];
            return $this->respondWithSuccess($result, '获取播放节点成功');
        } else {
            return $this->respondWithErrors('获取播放节点失败');
        }

    }
}
