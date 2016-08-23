<?php

namespace App\Http\Controllers\Api;

use App\Http\Model\Comment;
use App\Http\Model\MessageRecord;
use App\Http\Model\Tweets;
use App\Http\Model\User;
use App\Http\Model\VideoInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class CommentController extends BaseController
{
    public function __construct()
    {
        // 执行 jwt.auth 认证
        $this->middleware('jwt.api.auth', [
            'except' => [
                'getCommentList',
            ]
        ]);
    }
    
    /**
     * @api {post} /postComment.api 发布评论
     * @apiDescription 发布或者回复一条评论
     * @apiGroup Comment
     * @apiPermission Token
     * @apiHeader {String} token 登录成功返回的token
     * @apiHeaderExample {json} Header-Example:
     *      {
     *          "Authorization" : "Bearer {token}"
     *      }
     * @apiParam {Number} user_id 用户id
     * @apiParam {String} type 类型:tweet/video_info
     * @apiParam {Number} source_id 动弹或视频信息的id
     * @apiParam {String} content 评论内容
     * @apiParam {Number} pid 为0则评论当前主题.为其他评论id则是回复评论
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "发布评论信息成功",
     *           "data": null
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 400,
     *           "message": "发布评论信息失败"
     *      }
     */
    public function postComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id'],
            'type' => ['required', 'in:tweet,video_info'],
            'source_id' => ['required'],
            'content' => ['required'],
        ], [
            'user_id.required' => 'user_id字段不能为空',
            'user_id.exists' => '用户不存在',
            'type.required' => 'type字段不能为空',
            'type.in' => 'type字段只能是 tweet、video_info',
            'source_id.required' => 'source_id字段不能为空',
            'content.required' => 'content字段不能为空',
        ]);
        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        if ($request->pid != 0) {
            // 验证回复的评论是否存在
            $toComment = Comment::where('source_id', $request->source_id)->where('type', $request->type)->where('id', $request->pid)->first();
            if (isset($toComment)) {
                // 通知被回复的用户 - 回复评论
                MessageRecord::create([
                    'by_user_id' => $request->user_id,
                    'to_user_id' => $toComment->user_id,
                    'message_type' => 'comment',
                    'type' => $request->type,
                    'source_id' => $request->source_id,
                    'content' => $request->input('content'),
                ]);
            } else {
                return $this->respondWithErrors('没有找到当前source_id下pid对应的评论信息');
            }
        } else {
            // 通知被回复的用户 - 回复主题
            if ($request->type == 'tweet') {
                // 动态
                $tweet = Tweets::find($request->source_id);
                $to_user_id = $tweet->user_id;

                // 只有回复动态主题才通知,回复视频则不通知
                MessageRecord::create([
                    'by_user_id' => $request->user_id,
                    'to_user_id' => $to_user_id,
                    'message_type' => 'comment',
                    'type' => $request->type,
                    'source_id' => $request->source_id,
                    'content' => $request->input('content'),
                ]);
            }

        }

        // 添加评论信息
        Comment::create($request->all($request->only(['user_id', 'type', 'source_id', 'content', 'pid'])));
        return $this->respondWithSuccess(null, '添加评论成功');

    }

    /**
     * @api {get} /getCommentList.api 获取评论列表
     * @apiDescription 获取动弹或视频信息的评论列表
     * @apiGroup Comment
     * @apiPermission none
     * @apiParam {String} type 类型:tweet/video_info
     * @apiParam {Number} source_id 动弹或视频信息的id
     * @apiParam {Number} [page] 页码,默认当然是第1页
     * @apiParam {Number} [count] 每页数量,默认10条
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "查询评论列表成功",
     *           "result": {
     *               "pageInfo": {
     *                   "total": 2,
     *                   "currentPage": 1
     *               },
     *               "data": [
     *                   {
     *                       "id": 6,
     *                       "type": "tweet",
     *                       "sourceId": 5,
     *                       "content": "[怒][怒]",
     *                       "publishTime": "1471619839",
     *                       "author": {
     *                           "id": 10000,
     *                           "nickname": "管理员",
     *                           "avatar": "http://www.english.com/uploads/user/avatar/9f4ed11179f6962bd57cf9635474446b.jpg"
     *                       }
     *                   },
     *                   {
     *                       "id": 5,
     *                       "type": "tweet",
     *                       "sourceId": 5,
     *                       "content": "[吃惊]还可以",
     *                       "publishTime": "1471608154",
     *                       "author": {
     *                           "id": 10000,
     *                           "nickname": "管理员",
     *                           "avatar": "http://www.english.com/uploads/user/avatar/9f4ed11179f6962bd57cf9635474446b.jpg"
     *                       }
     *                   }
     *               ]
     *           }
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 400,
     *           "message": "没有任何评论信息"
     *      }
     */
    public function getCommentList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => ['required', 'in:tweet,video_info'],
            'source_id' => ['required'],
        ], [
            'type.required' => 'type字段不能为空',
            'type.in' => 'type字段只能是 tweet、video_info',
            'source_id.required' => 'source_id字段不能为空',
        ]);
        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        // 单页数量
        $count = isset($request->count) ? (int)$request->count : 10;
        $comments = Comment::where(['source_id' => $request->source_id, 'type' => $request->type])->orderBy('id', 'desc')->paginate($count);
        
        // 没有查询到数据
        $data = $comments->all();
        if (count($data) == 0) {
            return $this->respondWithErrors('没有任何评论信息', 404);
        }

        $result = null;
        foreach ($data as $key => $value) {
            $result[$key]['id'] = $value->id;
            $result[$key]['type'] = $value->type;
            $result[$key]['sourceId'] = $value->source_id;
            $result[$key]['content'] = $value->content;
            $result[$key]['publishTime'] = (string)$value->created_at->timestamp;

            // 评论作者
            $author = User::find($value->user_id);
            $result[$key]['author'] = [
                'id' => $author->id,
                'nickname' => $author->nickname,
                'avatar' => substr($author->avatar, 0, 4) == 'http' ? $author->avatar : url($author->avatar),
                'sex' => $author->sex
            ];

            // 如果是回复评论,则带上被回复用户的信息
            if ($value->pid != 0) {
                $puser = User::find(Comment::find($value->pid)->user_id);
                $result[$key]['extendsAuthor'] = [
                    'id' => $puser->id,
                    'nickname' => $puser->nickname,
                    'avatar' => substr($puser->avatar, 0, 4) == 'http' ? $puser->avatar : url($puser->avatar),
                    'sex' => $puser->sex
                ];
            }
        }

        return $this->respondWithSuccess([
            'pageInfo' => [
                'total' => $comments->total(),
                'currentPage' => $comments->currentPage(),
            ],
            'data' => $result,
        ], '查询评论列表成功');
    }
}


