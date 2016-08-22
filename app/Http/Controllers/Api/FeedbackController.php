<?php

namespace App\Http\Controllers\Api;

use App\Http\Model\Feedback;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends BaseController
{
    /**
     * @api {post} /postFeedback.api 意见反馈
     * @apiDescription 提交意见反馈信息
     * @apiGroup User
     * @apiPermission none
     * @apiParam {String} contact 联系方式
     * @apiParam {String} content 反馈内容
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "提交反馈信息成功",
     *           "data": null
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 400,
     *           "message": "contact不能为空"
     *      }
     */
    public function postFeedback(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contact' => ['required'],
            'content' => ['required']
        ], [
            'contact.required' => 'contact不能为空',
            'content.required' => 'content不能为空'
        ]);
        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        $feedback = Feedback::create($request->only(['contact', 'content']));
        if ($feedback) {
            return $this->respondWithSuccess(null, '提交反馈信息成功');
        } else {
            return $this->respondWithErrors('提交反馈信息失败');
        }
    }
}
