<?php

namespace App\Http\Controllers\Api;

use App\Http\Model\Manual;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class ManualController extends BaseController
{
    public function __construct()
    {
        // 执行 jwt.auth 认证
        $this->middleware('jwt.api.auth', [
            'except' => [
                'getManual',
            ]
        ]);
    }

    /**
     * @api {get} /getManual.api 获取语法手册
     * @apiDescription 获取所有语法数据,并存储到客户端
     * @apiGroup Grammar
     * @apiPermission none
     * @apiParam {Number} [page] 页码,默认当然是第1页
     * @apiParam {Number} [count] 每页数量,默认10条
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "查询动弹列表成功",
     *           "data": {
     *               "total": 55,
     *               "rows": 2,
     *               "current_page": 1,
     *               "data": [
     *                   {
     *                       "id": 1,
     *                       "title": "关于词类和句子成分",
     *                       "content": "根据词的形式、意义及其在句中的功用将词分为若干类，叫做词类。一个句子由各个功用不同的部分所构成，这些部分叫做句子成分。\n",
     *                       "created_at": null,
     *                       "updated_at": null
     *                   },
     *                   {
     *                       "id": 2,
     *                       "title": "英语词法和句法",
     *                       "content": "1.词法(morphology)词法研究的对象是各种词的形式及其用法。\n英语词类的形式变化有：名词和代词的数、格和性的形式变化；动词的人称、时态、语态、语气等形式变化；以及形容词和副词比较等级的形式变化。\n",
     *                       "created_at": null,
     *                       "updated_at": null
     *                   }
     *               ]
     *           }
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 400,
     *           "message": "失败"
     *      }
     */
    public function getManual(Request $request)
    {
        $count = isset($request->count) ? (int)$request->count : 10;      // 单页数量
        $grammars = Manual::paginate($count);

        if (! count($grammars)) {
            return $this->respondWithErrors('没有获取到任何数据');
        }

        return $this->respondWithSuccess([
            'pageInfo' => [
                'total' => $grammars->total(),
                'currentPage' => $grammars->currentPage(),
            ],
            'data' => $grammars->all(),
        ], '查询动弹列表成功');
    }
}
