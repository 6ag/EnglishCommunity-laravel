<?php

namespace App\Http\Controllers\Api;

use App\Http\Model\MessageRecord;
use App\Http\Model\Tweets;
use App\Http\Model\User;
use App\Http\Model\VideoInfo;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class MessageRecordController extends BaseController
{
    public function __construct()
    {
        $this->middleware('jwt.api.auth');
    }

    /**
     * @api {get} /getMessageList.api 获取消息列表
     * @apiDescription 获取个人消息列表,包括at和回复
     * @apiGroup Message
     * @apiPermission Token
     * @apiHeader {String} token 登录成功返回的token
     * @apiHeaderExample {json} Header-Example:
     *      {
     *          "Authorization" : "Bearer {token}"
     *      }
     * @apiParam {Number} user_id 用户id
     * @apiParam {Number} [page] 页码,默认当然是第1页
     * @apiParam {Number} [count] 每页数量,默认10条
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "获取消息列表成功",
     *           "result": {
     *               "pageInfo": {
     *                   "total": 2,
     *                   "currentPage": 1
     *               },
     *               "data": [
     *                   {
     *                   "byUser": {
     *                       "id": 10000,
     *                       "nickname": "管理员",
     *                       "avatar": "http://www.english.com/uploads/user/avatar/db2b62230870b0d8506f4c106b80693b.jpg",
     *                       "sex": 1
     *                   },
     *                   "toUser": {
     *                       "id": 10001,
     *                       "nickname": "王麻子",
     *                       "avatar": "http://www.english.com/uploads/user/default/avatar.jpg",
     *                       "sex": 0
     *                   },
     *                   "id": 5,
     *                   "messageType": "at",
     *                   "type": "tweet",
     *                   "sourceId": 11,
     *                   "content": "@王麻子 @李二狗 测试结果[怒]",
     *                   "looked": 0,
     *                   "publishTime": "1471920464",
     *                   "sourceContent": "王麻子:@王麻子 @李二狗 测试结果[怒]"
     *                   },
     *                   {
     *                   "byUser": {
     *                       "id": 10000,
     *                       "nickname": "管理员",
     *                       "avatar": "http://www.english.com/uploads/user/avatar/db2b62230870b0d8506f4c106b80693b.jpg",
     *                       "sex": 1
     *                   },
     *                   "toUser": {
     *                       "id": 10001,
     *                       "nickname": "王麻子",
     *                       "avatar": "http://www.english.com/uploads/user/default/avatar.jpg",
     *                       "sex": 0
     *                   },
     *                   "id": 2,
     *                   "messageType": "comment",
     *                   "type": "tweet",
     *                   "sourceId": 3,
     *                   "content": "我们一起努力加油[怒][怒]",
     *                   "looked": 0,
     *                   "publishTime": "1471919753",
     *                   "sourceContent": "王麻子:我也来测试一发，这是管理员的照片！[偷笑][偷笑][偷笑]"
     *                   }
     *               ]
     *           }
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 400,
     *           "message": "获取消息列表失败"
     *      }
     */
    public function getMessageList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id']
        ], [
            'user_id.required' => 'user_id不能为空',
            'user_id.exists' => '用户不存在'
        ]);
        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        $count = isset($request->count) ? (int)$request->count : 10;      // 单页数量
        $messageRecords = MessageRecord::where('to_user_id', $request->user_id)->orderBy('id', 'desc')->paginate($count);

        $data = $messageRecords->all();
        if (! count($data)) {
            return $this->respondWithErrors('还没有任何消息');
        }

        $result = null;
        foreach ($data as $key => $messageRecord) {
            // 消息来源
            $byUser = User::find($messageRecord->by_user_id);
            $result[$key]['byUser'] = [
                'id' => $byUser->id,
                'nickname' => $byUser->nickname,
                'avatar' => substr($byUser->avatar, 0, 4) == 'http' ? $byUser->avatar : url($byUser->avatar),
                'sex' => $byUser->sex
            ];
            $toUser = User::find($messageRecord->to_user_id);
            $result[$key]['toUser'] = [
                'id' => $toUser->id,
                'nickname' => $toUser->nickname,
                'avatar' => substr($toUser->avatar, 0, 4) == 'http' ? $toUser->avatar : url($toUser->avatar),
                'sex' => $toUser->sex
            ];
            $result[$key]['id'] = $messageRecord->id;
            $result[$key]['messageType'] = $messageRecord->message_type;
            $result[$key]['type'] = $messageRecord->type;
            $result[$key]['sourceId'] = $messageRecord->source_id;
            $result[$key]['content'] = $messageRecord->content;
            $result[$key]['looked'] = $messageRecord->looked;
            $result[$key]['publishTime'] = (string)$messageRecord->created_at->timestamp;
            if ($messageRecord->type == 'tweet') {
                $tweet = Tweets::find($messageRecord->source_id);
                $result[$key]['sourceContent'] = $toUser->nickname . '：' . $tweet->content;
            } else {
                $videoInfo = VideoInfo::find($messageRecord->source_id);
                $result[$key]['sourceContent'] = $videoInfo->title;
            }

        }

        return $this->respondWithSuccess([
            'pageInfo' => [
                'total' => $messageRecords->total(),
                'currentPage' => $messageRecords->currentPage(),
            ],
            'data' => $result,
        ], '获取消息列表成功');

    }

    /**
     * @api {get} /getUnlookedMessageCount.api 获取未读消息数量
     * @apiDescription 获取未读消息数量
     * @apiGroup Message
     * @apiPermission Token
     * @apiHeader {String} token 登录成功返回的token
     * @apiHeaderExample {json} Header-Example:
     *      {
     *          "Authorization" : "Bearer {token}"
     *      }
     * @apiParam {Number} user_id 用户id
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "获取消息数量成功",
     *           "result": {
     *
     *            }
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 400,
     *           "message": "获取消息数量失败"
     *      }
     */
    public function getUnlookedMessageCount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id']
        ], [
            'user_id.required' => 'user_id不能为空',
            'user_id.exists' => '用户不存在'
        ]);
        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        // 查询未读信息数量
        $unlookedMessageCount = MessageRecord::where('to_user_id', $request->user_id)->where('looked', 0)->count();

        return $this->respondWithSuccess([
            'unlookedMessageCount' => $unlookedMessageCount
        ], '查询未读信息数量成功');
    }

    /**
     * @api {post} /clearUnlookedMessage.api 清空未读消息
     * @apiDescription 清空未读消息记录
     * @apiGroup Message
     * @apiPermission Token
     * @apiHeader {String} token 登录成功返回的token
     * @apiHeaderExample {json} Header-Example:
     *      {
     *          "Authorization" : "Bearer {token}"
     *      }
     * @apiParam {Number} user_id 用户id
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "清空未读消息成功",
     *           "result": null
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 400,
     *           "message": "清空未读消息失败"
     *      }
     */
    public function clearUnlookedMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id']
        ], [
            'user_id.required' => 'user_id不能为空',
            'user_id.exists' => '用户不存在'
        ]);
        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        MessageRecord::where('to_user_id', $request->user_id)->where('looked', 0)->update(['looked' => 1]);

        return $this->respondWithSuccess(null, '清空未读消息成功');
    }
}
