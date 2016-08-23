<?php

namespace App\Http\Controllers\Api;

use App\Http\Model\Comment;
use App\Http\Model\LikeRecord;
use App\Http\Model\MessageRecord;
use App\Http\Model\Tweets;
use App\Http\Model\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class TweetsController extends BaseController
{
    public function __construct()
    {
        // 执行 jwt.auth 认证
        $this->middleware('jwt.api.auth', [
            'except' => [
                'getTweetsList',
                'getTweetsDetail',
            ]
        ]);
    }

    /**
     * @api {get} /getTweetsList.api 动弹列表
     * @apiDescription 获取动弹列表,可根据参数返回不同的数据
     * @apiGroup Tweet
     * @apiPermission none
     * @apiParam {String} type 返回类型 默认new, new最新 hot热门 me我的
     * @apiParam {Number} [page] 页码,默认当然是第1页
     * @apiParam {Number} [count] 每页数量,默认10条
     * @apiParam {Number} [user_id] 访客用户id,type为me,这个字段必须传,游客传0
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "查询动弹列表成功",
     *           "result": {
     *               "pageInfo": {
     *                   "total": 8,
     *                   "currentPage": 1
     *               },
     *               "data": [
     *                   {
     *                   "id": 8,
     *                   "appClient": 0,
     *                   "content": "[可爱][可爱]",
     *                   "commentCount": 0,
     *                   "likeCount": 1,
     *                   "liked": 0,
     *                   "publishTime": "1471687444",
     *                   "author": {
     *                       "id": 10000,
     *                       "nickname": "管理员",
     *                       "avatar": "http://www.english.com/uploads/user/avatar/9f4ed11179f6962bd57cf9635474446b.jpg"
     *                   },
     *                   "images": [
     *                       {
     *                           "href": "http://www.english.com/uploads/tweets/2016-08-20/acc95cb2adb4efbf9837dfdd74681571.jpg",
     *                           "thumb": "http://www.english.com/uploads/tweets/2016-08-20/acc95cb2adb4efbf9837dfdd74681571_thumb.jpg"
     *                       }
     *                   ]
     *                   },
     *                   {
     *                   "id": 7,
     *                   "appClient": 0,
     *                   "content": "三张",
     *                   "commentCount": 1,
     *                   "likeCount": 1,
     *                   "liked": 0,
     *                   "publishTime": "1471576544",
     *                   "author": {
     *                       "id": 10000,
     *                       "nickname": "管理员",
     *                       "avatar": "http://www.english.com/uploads/user/avatar/9f4ed11179f6962bd57cf9635474446b.jpg"
     *                   },
     *                   "images": [
     *                       {
     *                           "href": "http://www.english.com/uploads/tweets/2016-08-19/e1e7ec0fe33ee7290f90337bf94cad1a.jpg",
     *                           "thumb": "http://www.english.com/uploads/tweets/2016-08-19/e1e7ec0fe33ee7290f90337bf94cad1a_thumb.jpg"
     *                       },
     *                       {
     *                           "href": "http://www.english.com/uploads/tweets/2016-08-19/cbe5cf86c5138f520fc6cec43ec5fa0b.jpg",
     *                           "thumb": "http://www.english.com/uploads/tweets/2016-08-19/cbe5cf86c5138f520fc6cec43ec5fa0b_thumb.jpg"
     *                       },
     *                       {
     *                           "href": "http://www.english.com/uploads/tweets/2016-08-19/faf969467dea3ddf1dcd403852a3d68e.jpg",
     *                           "thumb": "http://www.english.com/uploads/tweets/2016-08-19/faf969467dea3ddf1dcd403852a3d68e_thumb.jpg"
     *                       }
     *                   ]
     *                   }
     *               ]
     *           }
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 404,
     *           "message": "查询动弹列表失败"
     *      }
     */
    public function getTweetsList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => ['required', 'in:new,hot,me'],
        ], [
            'type.required' => 'type不能为空',
            'type.in' => 'type只能是new、hot、me'
        ]);
        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        $type = $request->type;
        $count = isset($request->count) ? (int)$request->count : 10;      // 单页数量
        $user_id = isset($request->user_id) ? (int)$request->user_id : 0; // 请求用户

        // 根据参数过滤数据
        $tweets = Tweets::orderBy('id', 'desc');
        if ($type === 'new') {
            $tweets = $tweets->paginate($count);
        } elseif ($type === 'hot') {
            $tweets = $tweets->orderBy('view', 'desc')->paginate($count);
        } elseif ($type === 'me') {
            $tweets = $tweets->where('user_id', $user_id)->paginate($count);
        }

        // 只读一次到内存,节省资源
        $comments = Comment::where('type', 'tweet')->get();
        $likeRecords = LikeRecord::where('type', 'tweet')->get();

        // 返回数据
        $result = null;

        // 没有查询到数据
        $data = $tweets->all();
        if (count($data) == 0) {
            return $this->respondWithErrors('没有查询到动弹列表数据');
        }

        // 向单条数据里添加数据
        foreach ($data as $key => $value) {
            // 动弹作者
            $user = User::find($value->user_id);
            // 访客对这条动弹的赞记录
            $userLikeRecord = $likeRecords->where('source_id', $value->id)->where('user_id', $user_id)->first();

            $result[$key]['id'] = $value->id;
            $result[$key]['appClient'] = $value->app_client;
            $result[$key]['content'] = $value->content;
            $result[$key]['commentCount'] = $comments->where('source_id', $value->id)->count();
            $result[$key]['likeCount'] = $likeRecords->where('source_id', $value->id)->count();
            $result[$key]['liked'] = isset($userLikeRecord) ? 1 : 0;
            $result[$key]['publishTime'] = (string)$value->created_at->timestamp;
            $result[$key]['author'] = [
                'id' => $user->id,
                'nickname' => $user->nickname,
                'avatar' => substr($user->avatar, 0, 4) == 'http' ? $user->avatar : url($user->avatar),
                'sex' => $user->sex
            ];

            // 有图片才拆分
            if (! empty($value->photos)) {
                $photos = explode(',', $value->photos);
                $photoThumbs = explode(',', $value->photo_thumbs);
                $images = null;
                foreach ($photos as $k => $v) {
                    $images[$k]['href'] = url($photos[$k]);
                    $images[$k]['thumb'] = url($photoThumbs[$k]);
                }
                $result[$key]['images'] = $images;
            }

            // 有at用户才拆分
            if (! empty($value->at_nicknames)) {
                $at_user_ids = explode(',', $value->at_user_ids);
                $at_nicknames = explode(',', $value->at_nicknames);
                $at_users = null;
                foreach ($at_user_ids as $k => $v) {
                    $at_users[$k]['id'] = $at_user_ids[$k];
                    $at_users[$k]['nickname'] = $at_nicknames[$k];
                    $at_users[$k]['sequence'] = $k;
                }
                $result[$key]['atUsers'] = $at_users;
            }

        }

        return $this->respondWithSuccess([
            'pageInfo' => [
                'total' => $tweets->total(),
                'currentPage' => $tweets->currentPage(),
            ],
            'data' => $result,
        ], '查询动弹列表成功');
    }

    /**
     * @api {get} /getTweetsDetail.api 动弹详情
     * @apiDescription 获取动弹详情,获取动弹赞列表、评论列表是其他接口
     * @apiGroup Tweet
     * @apiPermission none
     * @apiParam {Number} tweet_id 动弹id
     * @apiParam {Number} [user_id] 访客用户id
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "查询动弹详情成功",
     *           "result": {
     *               "id": 1,
     *               "appClient": 0,
     *               "content": "[害羞]这是一条测试数据啊，你别看错了啊，这是一条测试数据。这是一条测试数据啊。",
     *               "commentCount": 0,
     *               "likeCount": 0,
     *               "liked": 0,
     *               "publishTime": "1471576204",
     *               "author": {
     *                   "id": 10000,
     *                   "nickname": "管理员",
     *                   "avatar": "http://www.english.com/uploads/user/avatar/9f4ed11179f6962bd57cf9635474446b.jpg"
     *               },
     *               "images": [
     *                   {
     *                       "href": "http://www.english.com/uploads/tweets/2016-08-19/d1c632b1b01a665e09665d53ba2a18f9.jpg",
     *                       "thumb": "http://www.english.com/uploads/tweets/2016-08-19/d1c632b1b01a665e09665d53ba2a18f9_thumb.jpg"
     *                   }
     *               ]
     *           }
     *       }
     * @apiErrorExample {json} Error-Response:
     *       {
     *           "status": "error",
     *           "code": 400,
     *           "message": "tweet_id不能为空"
     *       }
     */
    public function getTweetsDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tweet_id' => ['required', 'exists:tweets,id'],
        ], [
            'tweet_id.required' => 'tweet_id不能为空',
            'tweet_id.exists' => '动弹不存在'
        ]);
        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        // 请求用户
        $user_id = isset($request->user_id) ? (int)$request->user_id : 0;

        // 当前动弹
        $tweet = Tweets::find($request->tweet_id);

        // 当前动弹的作者
        $user = User::find($tweet->user_id);
        $userLikeRecord = LikeRecord::where('type', 'trends')->where('source_id', $tweet->id)->where('user_id', $user_id)->first();

        // 浏览量递增
        $tweet->increment('view');

        // 返回数据
        $result = null;
        $result['id'] = $tweet->id;
        $result['appClient'] = $tweet->app_client;
        $result['content'] = $tweet->content;
        $result['commentCount'] = Comment::where('type', 'tweet')->where('source_id', $tweet->id)->count();
        $result['likeCount'] = LikeRecord::where('type', 'tweet')->where('source_id', $tweet->id)->count();
        $result['liked'] = isset($userLikeRecord) ? 1 : 0;
        $result['publishTime'] = (string)$tweet->created_at->timestamp;

        // 动弹的作者
        $result['author'] = [
            'id' => $user->id,
            'nickname' => $user->nickname,
            'avatar' => substr($user->avatar, 0, 4) == 'http' ? $user->avatar : url($user->avatar),
            'sex' => $user->sex
        ];

        // 有配图拆分
        if (! empty($tweet->photos)) {
            $photos = explode(',', $tweet->photos);
            $photoThumbs = explode(',', $tweet->photo_thumbs);
            $images = null;
            foreach ($photos as $k => $v) {
                $images[$k]['href'] = url($photos[$k]);
                $images[$k]['thumb'] = url($photoThumbs[$k]);
            }
            $result['images'] = $images;
        }

        // 有at用户拆分
        if (! empty($tweet->at_nicknames)) {
            $at_user_ids = explode(',', $tweet->at_user_ids);
            $at_nicknames = explode(',', $tweet->at_nicknames);
            $at_users = null;
            foreach ($at_user_ids as $k => $v) {
                $at_users[$k]['id'] = $at_user_ids[$k];
                $at_users[$k]['nickname'] = $at_nicknames[$k];
                $at_users[$k]['sequence'] = $k;
            }
            $result['atUsers'] = $at_users;
        }

        return $this->respondWithSuccess($result, '查询动弹详情成功');

    }

    /**
     * @api {post} /postTweets.api 发布动弹
     * @apiDescription 发布一条新的动弹
     * @apiGroup Tweet
     * @apiPermission Token
     * @apiHeader {String} token 登录成功返回的token
     * @apiHeaderExample {json} Header-Example:
     *      {
     *          "Authorization" : "Bearer {token}"
     *      }
     * @apiParam {Number} user_id 作者用户id
     * @apiParam {String} content 动弹内容
     * @apiParam {JSON} [photos] ['base64'] 动弹配图,base64编码的图片数组
     * @apiParam {JSON} [atUsers] [{'id':'10000','nickname':'管理员'}] 被at的用户
     * @apiParam {Number} [app_client] 客户端类型 0iOS 1Android
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "发布动弹成功",
     *           "data": null
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 400,
     *           "message": "发布动弹失败"
     *      }
     */
    public function postTweets(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id'],
            'content' => ['required']
        ], [
            'user_id.required' => 'user_id不能为空',
            'user_id.exists' => '用户不存在',
            'content.required' => '发布内容不能为空'
        ]);
        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        // 客户端类型
        $app_client = isset($request->app_client) ? $request->app_client : 0;

        // 处理图片
        $originalPaths = null;
        $thumbPaths = null;
        if (isset($request->photos)) {
            $base64Photos = json_decode($request->photos, true);
            foreach ($base64Photos as $key => $base64Photo) {
                $originalImage = Image::make($base64Photo);
                $thumbImage = Image::make($base64Photo)->resize(150, null, function ($constraint) {
                    // 等比缩放图片,固定宽度150
                    $constraint->aspectRatio();
                });

                // 生成唯一的图片名 0ac23ab277e4b0e458e5aeccb49e327c.jpg 0ac23ab277e4b0e458e5aeccb49e327c_thumb.jpg
                $extend = '.jpg';
                $uniqueFileName = md5(uniqid(microtime(true), true));
                $originalFileName = $uniqueFileName . $extend;
                $thumbFileName = $uniqueFileName . '_thumb' . $extend;

                // 根据日期创建目录 uploads/tweets/2016-08-15/
                $carbon = Carbon::now();
                $directory = 'uploads/tweets/' . $carbon->toDateString() . '/';
                if (!file_exists($directory)) {
                    if (!(mkdir($directory, 0777, true) && chmod($directory, 0777))) {
                        return $this->respondWithErrors('无权限创建路径,请设置public下的uploads目录权限为777', 500);
                    }
                }

                // 拼接最终图片路径
                $originalPath = $directory . $originalFileName;
                $thumbPath = $directory . $thumbFileName;

                // 存储图片到指定目录
                $originalImage->save($originalPath);
                $thumbImage->save($thumbPath);

                // 将路径存储到数组中,准备入库
                $originalPaths[$key] = $originalPath;
                $thumbPaths[$key] = $thumbPath;

                // 修改保存的图片权限
                @chmod($originalPath, 0777);
                @chmod($thumbPath, 0777);
            }

            $originalPaths = implode(',', $originalPaths);
            $thumbPaths = implode(',', $thumbPaths);
        }

        // 处理被at用户
        $at_user_ids = null;
        $at_nicknames = null;
        if (isset($request->atUsers)) {
            $atUsers = json_decode($request->atUsers, true);
            foreach ($atUsers as $key => $atUser) {
                $at_user_ids[$key] = $atUser['id'];
                $at_nicknames[$key] = $atUser['nickname'];
            }

            $at_user_ids = implode(',', $at_user_ids);
            $at_nicknames = implode(',', $at_nicknames);
        }

        $tweet = new Tweets();
        $tweet->user_id = $request->user_id;
        $tweet->app_client = $app_client;
        $tweet->content = $request->input('content');

        // 发布参数中带配图
        if (isset($originalPaths) && isset($thumbPaths)) {
            $tweet->photos = $originalPaths;
            $tweet->photo_thumbs = $thumbPaths;
        }

        // 发布参数中有at其他用户
        if (isset($at_nicknames) && isset($at_user_ids)) {
            $tweet->at_nicknames = $at_nicknames;
            $tweet->at_user_ids = $at_user_ids;
        }
        $tweet->save();

        // 给被at的用户发送信息
        if (isset($request->atUsers)) {
            $atUsers = json_decode($request->atUsers, true);
            foreach ($atUsers as $key => $atUser) {
                MessageRecord::create([
                    'by_user_id' => $request->user_id,
                    'to_user_id' => $atUser['id'],
                    'message_type' => 'at',
                    'type' => 'tweet',
                    'source_id' => $tweet->id,
                    'content' => $request->input('content'),
                ]);
            }
        }

        return $this->respondWithSuccess(null, '发布动弹成功');

    }

}
